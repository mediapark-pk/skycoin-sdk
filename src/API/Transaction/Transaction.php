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
        return $this->client->sendRequest("/pendingTxs?".$params, [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createTransaction(array $params){
        return $this->client->sendRequest("/transaction", $params, []);
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function injectRawTransaction(array $params){
        return $this->client->sendRequest("/transaction", $params, []);
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getTransaction(string $params){
        return $this->client->sendRequest("/transaction?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getRawTransaction(string $params){
        return $this->client->sendRequest("/transaction?".$params, [], [], "GET");
    }

}