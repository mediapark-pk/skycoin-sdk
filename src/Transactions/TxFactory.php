<?php
declare(strict_types=1);

namespace SkyCoin\Transactions;

use SkyCoin\SkyCoin;

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
}
