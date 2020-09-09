<?php


namespace SkyCoin\API\SimpleQuery;

use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use Skycoin\HttpClient;
class SimpleQuery
{
    /*** @var HttpClient*/
    private HttpClient $client;

    /**
     * Generic constructor.
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $addresses
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function getBalance(string $addresses){
        return $this->client->sendRequest("/v1/balance?".$addresses, [], [], "GET");
    }

    /**
     * @param string $addresses
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function getUnspent(string $addresses){
        return $this->client->sendRequest("/v1/outputs?".$addresses, [], [], "GET");
    }

}