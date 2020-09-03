<?php
declare(strict_types=1);

namespace SkyCoin\API\Wallet;


use http\Params;
use SkyCoin\HttpClient;

/**
 * Class Wallet
 * @package SkyCoin\API\Wallet
 */
class Wallet
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
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getWallet(string $queryString)
    {
        return $this->client->sendRequest("/wallet?" . $queryString, [], [], "GET");
    }


    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createWallet(array $params, array $headers)
    {

        return $this->client->sendRequest("/wallet/create", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function unconfirmedTransactions(string $queryString)
    {
        return $this->client->sendRequest("/wallet/transactions?" . $queryString, [], [], "GET");
    }


    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function wallets()
    {
        return $this->client->sendRequest("/wallets", [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function folderName()
    {
        return $this->client->sendRequest("/wallets/folderName", [], [], "GET");
    }


    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function generateSeed() //skip
    {
        return $this->client->sendRequest("/wallet/newSeed", [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function verifySeed(array $params) //skip
    {
        return $this->client->sendRequest("/wallet/seed/verify", $params);


    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function newAddress(array $params, array $headers)
    {

        return $this->client->sendRequest("/wallet/newAddress", $params, $headers);
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function scanAddress(array $params)
    {
        return $this->client->sendRequest("/wallet/scan", $params);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function walletUpdate(array $params, array $headers)
    {
        return $this->client->sendRequest("/wallet/update", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function walletBalance(string $queryString)
    {
        return $this->client->sendRequest("/wallet/balance?" . $queryString, [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createTransaction($params)
    {
        return $this->client->sendRequest("/wallet/transaction", $params, []);
    }


    /**
     * @param array $param
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function unloadWallet(array $param, array $headers)
    {
        return $this->client->sendRequest("/wallet/unload", $param, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function encryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/wallet/encrypt", $params, $headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function decryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/wallet/encrypt", $params, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function walletSeed(array $params, array $headers)
    {
        return $this->client->sendRequest("/wallet/seed", $params, $headers);
    }

    /**
     * @param $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function recoverBySeed($params)
    {
        return $this->client->sendRequest("/wallet/recover", $params);


    }


}