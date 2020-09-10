<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

use SkyCoin\Exception\SkyCoinTxException;
use SkyCoin\Validator;

/**
 * Class SpendTxConstructor
 * @package SkyCoin\Wallets
 */
class SpendTxConstructor
{
    /** @var Wallet */
    private Wallet $wallet;
    /** @var string */
    private string $hours;
    /** @var string|null */
    private ?string $hoursShareFactor;
    /** @var string|null */
    private ?string $changeAddress;
    /** @var bool */
    private bool $unSigned;
    /** @var bool */
    private bool $ignoreUnconfirmed;
    /** @var array */
    private array $payees;

    /**
     * SpendTxConstructor constructor.
     * @param Wallet $wallet
     */
    public function __construct(Wallet $wallet)
    {
        $this->wallet = $wallet;
        $this->hours = "manual";
        $this->unSigned = false;
        $this->ignoreUnconfirmed = true;
        $this->payees = [];
    }

    /**
     * @return PreparedTx
     * @throws SkyCoinTxException
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     */
    public function generate(): PreparedTx
    {
        return $this->wallet->createTransaction($this);
    }

    /**
     * @return array
     */
    public function array(): array
    {
        $hours = [
            "type" => $this->hours,
        ];

        if ($this->hours === "auto") {
            $hours["mode"] = "share";
            $hours["share_factor"] = $this->hoursShareFactor;
        }

        $txn = [
            "hours_selection" => $hours,
            "unsigned" => $this->unSigned,
            "ignore_unconfirmed" => $this->ignoreUnconfirmed,
            "to" => $this->payees,
        ];

        if (isset($this->changeAddress)) {
            $txn["change_address"] = $this->changeAddress;
        }

        return $txn;
    }

    /**
     * @param float $shareFactor
     * @return $this
     * @throws SkyCoinTxException
     */
    public function autoHours(float $shareFactor): self
    {
        $shareFactor = bcmul(strval($shareFactor), "1", 1);
        if (bccomp($shareFactor, "0", 1) === -1 || bccomp($shareFactor, "1", 1) === 1) {
            throw new SkyCoinTxException('Invalid auto-hours share factor');
        }

        $this->hours = "auto";
        $this->hoursShareFactor = $shareFactor;
        return $this;
    }

    /**
     * @param string $addr
     * @param string $coins
     * @param string|null $hours
     * @return $this
     * @throws SkyCoinTxException
     */
    public function to(string $addr, string $coins, ?string $hours = null): self
    {
        if (!Validator::isValidAddress($addr)) {
            throw new SkyCoinTxException('Invalid payee address');
        }

        $payee = [
            "address" => $addr,
            "coins" => $coins,
            "hours" => $hours ?? "0",
        ];

        $this->payees[] = $payee;
        return $this;
    }

    /**
     * @param string $changeAddr
     * @return $this
     * @throws SkyCoinTxException
     */
    public function changeAddress(string $changeAddr): self
    {
        if (!Validator::isValidAddress($changeAddr)) {
            throw new SkyCoinTxException('Invalid change address');
        }

        $this->changeAddress = $changeAddr;
        return $this;
    }

    /**
     * @param bool $sign
     * @return $this
     */
    public function signTransaction(bool $sign): self
    {
        $this->unSigned = $sign === true ? false : true;
        return $this;
    }

    /**
     * @return $this
     */
    public function ignoreUnconfirmed(): self
    {
        $this->ignoreUnconfirmed = false;
        return $this;
    }
}
