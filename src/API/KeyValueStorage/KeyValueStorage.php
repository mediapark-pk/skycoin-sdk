<?php


namespace SkyCoin\API\KeyValueStorage;


use SkyCoin\HttpClient;

class KeyValueStorage
{
    /*** @var HttpClient */
    private HttpClient $client;

    /**
     * Generic constructor.
     * @param HttpClient $client
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    public function getAllStorage(string $params){
        return $this->client->sendRequest("/v1/data?".$params, [], []);
    }
}