<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\Exception\SkyCoinTxException;
use SkyCoin\Exception\SkyCoinWalletException;
use SkyCoin\SkyCoin;
use SkyCoin\Validator;

/**
 * Class Wallet
 * @package SkyCoin\Wallets
 */
class Wallet
{
    /** @var SkyCoin */
    private SkyCoin $skyCoin;
    /** @var string */
    private string $filename;
    /** @var string|null */
    private ?string $password = null;

    /**
     * Wallet constructor.
     * @param SkyCoin $skyCoin
     * @param string $walletFilename
     * @param string|null $password
     * @throws SkyCoinWalletException
     */
    public function __construct(SkyCoin $skyCoin, string $walletFilename, ?string $password = null)
    {
        if (!Validator::isValidWalletFilename($walletFilename)) {
            throw new SkyCoinWalletException('Invalid wallet identifier/filename');
        }

        $this->skyCoin = $skyCoin;
        $this->filename = $walletFilename;
        if ($password) {
            $this->setPassword($password);
        }
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     * @throws SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function createAddress(): string
    {
        if (!isset($this->password)) {
            throw new SkyCoinAPIException('Password is required to create address');
        }

        $headers = [
            "Content-Type" => "application/x-www-form-urlencoded"
        ];

        $params = [
            "id" => $this->filename,
            "password" => $this->password,
            "num" => 1,
        ];

        $data = $this->skyCoin->httpClient()->sendRequest("/v1/wallet/newAddress", $params, $headers, "POST");
        $addresses = $data["addresses"] ?? null;
        if (!is_array($addresses) || !$addresses) {
            throw new SkyCoinAPIException('Addresses object not found in newAddress response');
        }

        $address = $addresses[0];
        if (!Validator::isValidAddress($address)) {
            throw new SkyCoinAPIException('Invalid newly generated address');
        }

        return $address;
    }

    /**
     * @return Balance
     * @throws SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function getBalance(): Balance
    {
        $data = $this->skyCoin->httpClient()->sendRequest("/v1/wallet/balance?id=" . $this->filename);

        $balance = new Balance();
        $confirmed = $data["confirmed"];
        $predicted = $data["predicted"];
        if (!is_array($confirmed) || !$confirmed) {
            throw new SkyCoinAPIException('Failed to retrieve confirmed wallet balance');
        }

        $balance->confirmedCoins = $confirmed["coins"];
        $balance->confirmedHours = $confirmed["hours"];
        $balance->predictedCoins = $predicted["coins"];
        $balance->predictedHours = $predicted["hours"];

        return $balance;
    }

    /**
     * @return SpendTxConstructor
     */
    public function newTransaction(): SpendTxConstructor
    {
        return new SpendTxConstructor($this);
    }

    /**
     * @param SpendTxConstructor $spendTx
     * @return PreparedTx
     * @throws SkyCoinAPIException
     * @throws SkyCoinTxException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function createTransaction(SpendTxConstructor $spendTx): PreparedTx
    {
        $spendTx = $spendTx->array();
        $spendTx["wallet_id"] = $this->filename;
        if ($this->password) {
            $spendTx["password"] = $this->password;
        }

        if ($spendTx["unsigned"] === false && !isset($spendTx["password"])) {
            throw new SkyCoinTxException('Wallet password is required to sign transaction');
        }

        $tx = $this->skyCoin->httpClient()->sendRequest("/v1/wallet/transaction", $spendTx, [], "POST");
        return new PreparedTx($tx);
    }
}
