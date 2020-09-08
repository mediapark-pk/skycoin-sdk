<?php

namespace SkyCoin\API\Transaction;


use SkyCoin\HttpClient;

class Transaction
{
    private HttpClient $client;

    /**
     * Generic constructor.
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function pendingTxs(string $params=''){
        return $this->client->sendRequest("/v1/pendingTxs?".$params, [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createTransaction(array $params){
        return $this->client->sendRequest("/v2/transaction", $params, []);
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getTransactions(string $params){
        return $this->client->sendRequest("/v1/transactions?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @param int $param2
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getTransaction(string $params,int $param2=0){
        return $this->client->sendRequest("/v1/transaction?txid=".$params."&confirmed=".$param2, [], [], "GET");
    }

    public function resendUnconfirmedTxns(array $params){
        return $this->client->sendRequest("/v1/resendUnconfirmedTxns", $params, []);
    }

    public function verify(array $params){
        return $this->client->sendRequest("v2/transaction/verify", $params, []);
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getRawTransaction(string $params){
        return $this->client->sendRequest("/v1/rawtx?".$params, [], [], "GET");
    }

    /**
     * @param $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function injectTransaction($params){
        return $this->client->sendRequest("/v1/injectTransaction", $params, []);
    }

}