<?php


namespace SkyCoin\API\coinSupply;


use SkyCoin\HttpClient;

class coinSupply
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
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function coinSupply(){
        return $this->client->sendRequest("/v1/coinSupply", [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function richlist(string $params){
        return $this->client->sendRequest("/v1/richlist?".$params, [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function addresscount(){
        return $this->client->sendRequest("/v1/addresscount", [], [], "GET");
    }




}