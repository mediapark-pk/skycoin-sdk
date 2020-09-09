<?php


namespace SkyCoin\API\Uxout;


use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\HttpClient;

class Uxout
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
     * @param string $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function uxout(string $params)
    {
        return $this->client->sendRequest("/v1/uxout?uxid=".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function address_uxouts(string $params)
    {
        return $this->client->sendRequest("/v1/address_uxouts?address=".$params,[],[],'GET');
    }

}