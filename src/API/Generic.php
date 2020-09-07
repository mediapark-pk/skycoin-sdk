<?php

namespace SkyCoin\API;
use SkyCoin\HttpClient;
/**
 * Class Generic
 * @package SkyCoin
 */
class Generic
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
     * @return \Exception|Exception
     * @throws Exception\SkyCoinException
     */
    public function csrfToken()
    {
        return $this->client->sendRequest("/v1/csrf", [], [], "GET");
    }
}