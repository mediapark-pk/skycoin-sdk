<?php


namespace SkyCoin\API\GeneralSystem;


use SkyCoin\HttpClient;

class GeneralSystem
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
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function healthCheck(){
        return $this->client->sendRequest("/health", [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function versionInfo(){
        return $this->client->sendRequest("/version", [], [], "GET");
    }
}