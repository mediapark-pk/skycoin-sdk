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
        return $this->client->sendRequest("/v1/wallet?" . $queryString, [], [], "GET");
    }


    /**
     * @param string $seed
     * @param string $label
     * @param string $password
     * @param string $type
     * @param int $scan
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createWallet($params,$headers)
    {

        return $this->client->sendRequest("/v1/wallet/create", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function unconfirmedTransactions(string $queryString)
    {
        return $this->client->sendRequest("/v1/wallet/transactions?" . $queryString, [], [], "GET");
    }


    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function wallets()
    {
        return $this->client->sendRequest("/v1/wallets", [], [], "GET");
    }

    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function folderName()
    {
        return $this->client->sendRequest("/v1/wallets/folderName", [], [], "GET");
    }


    /**
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function generateSeed()
    {
        return $this->client->sendRequest("/v1/wallet/newSeed", [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function verifySeed(array $params)
    {
        return $this->client->sendRequest("/v2/wallet/seed/verify", $params);


    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function newAddress(array $params, array $headers)
    {

        return $this->client->sendRequest("/v1/wallet/newAddress", $params, $headers);
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function scanAddress(array $params,array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/scan", $params,$headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function changeWalletLabel(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/update", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function walletBalance(string $queryString)
    {
        return $this->client->sendRequest("/v1/wallet/balance?" . $queryString, [], [], "GET");
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createTransaction(array $params)
    {
        return $this->client->sendRequest("/v1/wallet/transaction", $params, []);
    }

    /**
     * @param array $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function signTransaction(array $params)
    {
        return $this->client->sendRequest("/v2/wallet/transaction/sign", $params, []);

    }


    /**
     * @param array $param
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function unloadWallet(array $param, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/unload", $param, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function encryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/encrypt", $params, $headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function decryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/decrypt", $params, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function walletSeed(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/seed", $params, $headers);
    }

    /**
     * @param $params
     * @return \Exception|\SkyCoin\Exception
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function recoverBySeed($params)
    {
        return $this->client->sendRequest("/v1/wallet/recover", $params);


    }


}