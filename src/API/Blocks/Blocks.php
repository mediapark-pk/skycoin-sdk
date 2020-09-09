<?php


namespace SkyCoin\API\Blocks;
use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinException;
use SkyCoin\HttpClient;

/**
 * Class Blocks
 * @package SkyCoin\API\Blocks
 */
class Blocks
{
    /** @var HttpClient */
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
     * @param string $params
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function getBlocks(string $params)
    {
        return $this->client->sendRequest("/v1/blocks?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function getblockchain(string $params)
    {
        return $this->client->sendRequest("/v1/blockchain/".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function getBlock(string $params)
    {
        return $this->client->sendRequest("/v1/block?".$params, [], [], "GET");
    }

    /**
     * @param string $params
     * @return array
     * @throws SkyCoinException|HttpException
     */
    public function lastnBlocks(string $params)
    {
        return $this->client->sendRequest("/v1/last_blocks?".$params, [], [], "GET");
    }

    /**
     * @throws SkyCoinException|HttpException
     */
    public function blockMetaData()
    {
        return $this->client->sendRequest("/v1/blockchain/metadata", [], [], "GET");
    }

}