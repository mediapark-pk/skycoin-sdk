<?php


namespace SkyCoin\API\Blocks;


use SkyCoin\HttpClient;

/**
 * Class Blocks
 * @package SkyCoin\API\Blocks
 */
class Blocks
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
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getBlocks(string $params)
    {
        return $this->client->sendRequest("/v1/blocks?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getblockchain(string $params)
    {
        return $this->client->sendRequest("/v1/blockchain/".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getBlock(string $params)
    {
        return $this->client->sendRequest("/v1/block?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function lastnBlocks(string $params)
    {
        return $this->client->sendRequest("/v1/last_blocks?".$params, [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function blockMetaData()
    {
        return $this->client->sendRequest("/v1/blockchain/metadata", [], [], "GET");
    }

}