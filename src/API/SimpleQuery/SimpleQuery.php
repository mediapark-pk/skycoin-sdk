<?php


namespace SkyCoin\API\SimpleQuery;

use Skycoin\HttpClient;
class SimpleQuery
{
    /**
     * @var HttpClient
     */
    private HttpClient $client;

    /**
     * Generic constructor.
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $addresses
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getBalance(string $addresses){
        return $this->client->sendRequest("/v1/balance?".$addresses, [], [], "GET");
    }

    /**
     * @param string $addresses
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getUnspent(string $addresses){
        return $this->client->sendRequest("/v1/outputs?".$addresses, [], [], "GET");
    }

}