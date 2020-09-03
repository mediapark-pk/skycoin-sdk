<?php


namespace SkyCoin\API\Wallet;


use SkyCoin\HttpClient;

class Wallet
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
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getWallet(string $queryString)
    {
        return $this->client->sendRequest("/wallet?" . $queryString, [], [], "GET");
    }

    public function createWallet(array $params)
    {

        return $this->client->sendRequest("/wallet/create", $params, ["Content-Type" => "application/x-www-form-urlencoded"]);
    }
}