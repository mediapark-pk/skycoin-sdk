<?php
declare(strict_types=1);

namespace SkyCoin\API\Network;

use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\Exception\SkyCoinException;
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
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $queryString
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function networkConnection(string $queryString)
    {
        return $this->client->sendRequest("/v1/network/connection?" . $queryString, [], [], "GET");
    }

    /**
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function networkConnections()
    {
        return $this->client->sendRequest("/v1/network/connections", [], [], "GET");

    }

    /**
     * @throws SkyCoinException|HttpException
     */
    public function defaultConnections()
    {
        return $this->client->sendRequest("/v1/network/defaultConnections", [], [], "GET");
    }

    /**
     * @throws SkyCoinException|HttpException
     */
    public function trustedConnections()
    {
        return $this->client->sendRequest("/v1/network/connections/trust", [], [], "GET");

    }

    /**
     * @throws SkyCoinException|HttpException
     */
    public function networkByPeerExchange()
    {
        return $this->client->sendRequest("/v1/network/connections/exchange", [], [], "GET");
    }


    /**
     * @param string $queryString
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function disconnectNetwork(string $queryString)
    {
        return $this->client->sendRequest("/v1/network/connection/disconnect?" . $queryString, []);
    }


}