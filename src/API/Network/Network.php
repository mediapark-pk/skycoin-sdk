<?php


namespace SkyCoin\API\Network;


use http\Exception\UnexpectedValueException;
use SkyCoin\HttpClient;

/**
 * Class Network
 * @package SkyCoin\API\Network
 */
class Network
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
    public function networkConnection(string $queryString)
    {
        return $this->client->sendRequest("/network/connection?" . $queryString, [], [], "GET");
    }

    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function networkConnections()
    {
        return $this->client->sendRequest("/network/connections", [], [], "GET");

    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function defaultConnections()
    {
        return $this->client->sendRequest("/network/defaultConnections", [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function trustedConnections()
    {
        return $this->client->sendRequest("/network/connections/trust", [], [], "GET");

    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function networkByPeerExchange()
    {
        return $this->client->sendRequest("/network/connections/exchange", [], [], "GET");
    }


    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function disconnectNetwork(string $queryString)
    {
        return $this->client->sendRequest("/network/connection/disconnect?" . $queryString, []);
    }


}