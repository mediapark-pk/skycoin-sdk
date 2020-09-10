<?php
declare(strict_types=1);

namespace SkyCoin\Transactions;

use SkyCoin\Exception\SkyCoinTxException;
use SkyCoin\SkyCoin;
use SkyCoin\Wallets\PreparedTx;

/**
 * Class TxFactory
 * @package SkyCoin\Transactions
 */
class TxFactory
{
    /** @var SkyCoin */
    private SkyCoin $skyCoin;

    /**
     * TxFactory constructor.
     * @param SkyCoin $sc
     */
    public function __construct(SkyCoin $sc)
    {
        $this->skyCoin = $sc;
    }

    /**
     * @param string $txId
     * @return Transaction
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     * @throws \SkyCoin\Exception\SkyCoinTxException
     */
    public function getById(string $txId): Transaction
    {
        $tx = $this->skyCoin->httpClient()->sendRequest(sprintf("/v1/transaction?txid=%s&verbose=1", $txId));
        return new Transaction($tx);
    }

    /**
     * @param $encodedTx
     * @return bool
     * @throws SkyCoinTxException
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     */
    public function inject($encodedTx): bool
    {
        if ($encodedTx instanceof PreparedTx) {
            $encodedTx = $encodedTx->encodedTx;
        }

        if (!is_string($encodedTx) || !preg_match('/^[a-f0-9]+$/i', $encodedTx)) {
            throw new SkyCoinTxException('Invalid encoded transaction; Cannot broadcast');
        }

        $this->skyCoin->httpClient()->sendRequest(
            "/v1/injectTransaction",
            ["rawtx" => $encodedTx],
            [],
            "POST"
        );

        return true;
    }
}
