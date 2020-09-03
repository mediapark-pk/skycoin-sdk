<?php


namespace SkyCoin\API\Blocks;


use SkyCoin\HttpClient;

class Blocks
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
    public function getBlocks(string $params)
    {
        return $this->client->sendRequest("/blocks?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getblockchain(string $params)
    {
        return $this->client->sendRequest("/blockchain/".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getBlock(string $params)
    {
        return $this->client->sendRequest("/block?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function lastnBlocks(string $params)
    {
        return $this->client->sendRequest("/last_blocks?".$params, [], [], "GET");
    }

}