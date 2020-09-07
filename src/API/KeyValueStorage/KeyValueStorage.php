<?php


namespace SkyCoin\API\KeyValueStorage;


use SkyCoin\HttpClient;

class KeyValueStorage
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

    public function getAllStorage(string $params){
        return $this->client->sendRequest("/data?".$params, [], []);
    }
}