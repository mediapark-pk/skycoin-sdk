<?php


namespace SkyCoin\API\Uxout;


use SkyCoin\HttpClient;

class Uxout
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
    public function uxout(string $params)
    {
        return $this->client->sendRequest("/v1/uxout?uxid=".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function address_uxouts(string $params)
    {
        return $this->client->sendRequest("/v1/address_uxouts?address=".$params,[],[],'GET');
    }

}