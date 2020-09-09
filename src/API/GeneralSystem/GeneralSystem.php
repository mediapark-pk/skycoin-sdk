<?php


namespace SkyCoin\API\GeneralSystem;


use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\HttpClient;

class GeneralSystem
{

    /** @var HttpClient*/
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
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function healthCheck(){
        return $this->client->sendRequest("/v1/health", [], [], "GET");
    }

    /**
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function versionInfo(){
        return $this->client->sendRequest("/v1/version", [], [], "GET");
    }
}