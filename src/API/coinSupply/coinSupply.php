<?php


namespace SkyCoin\API\coinSupply;


use Comely\Http\Exception\HttpException;
use SkyCoin\Exception;
use SkyCoin\HttpClient;

class coinSupply
{
    private HttpClient $client;

    /**
     * Generic constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @return array
     * @throws Exception\SkyCoinAPIException
     * @throws HttpException
     */
    public function coinSupply(){
        return $this->client->sendRequest("/v1/coinSupply", [], [], "GET");
    }

    /**
     * @param string $params
     * @return array
     * @throws Exception\SkyCoinAPIException
     * @throws HttpException
     */
    public function richlist(string $params){
        return $this->client->sendRequest("/v1/richlist?".$params, [], [], "GET");
    }

    /**
     * @return array
     * @throws Exception\SkyCoinAPIException
     * @throws HttpException
     */
    public function addresscount(){
        return $this->client->sendRequest("/v1/addresscount", [], [], "GET");
    }




}