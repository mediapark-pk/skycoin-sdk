<?php
declare(strict_types=1);

namespace SkyCoin\API\Wallet;


use Comely\Http\Exception\HttpException;
use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\HttpClient;

/**
 * Class Wallet
 * @package SkyCoin\API\Wallet
 */
class Wallet
{

    /*** @var HttpClient*/
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
     * @param string $queryString
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function getWallet(string $queryString)
    {
        return $this->client->sendRequest("/v1/wallet?" . $queryString, [], [], "GET");
    }


    /**
     * @param $params
     * @param $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function createWallet($params,$headers)
    {

        return $this->client->sendRequest("/v1/wallet/create", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function unconfirmedTransactions(string $queryString)
    {
        return $this->client->sendRequest("/v1/wallet/transactions?" . $queryString, [], [], "GET");
    }


    /**
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function wallets()
    {
        return $this->client->sendRequest("/v1/wallets", [], [], "GET");
    }

    /**
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function folderName()
    {
        return $this->client->sendRequest("/v1/wallets/folderName", [], [], "GET");
    }


    /**
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function generateSeed()
    {
        return $this->client->sendRequest("/v1/wallet/newSeed", [], [], "GET");
    }

    /**
     * @param array $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function verifySeed(array $params)
    {
        return $this->client->sendRequest("/v2/wallet/seed/verify", $params);


    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function newAddress(array $params, array $headers)
    {

        return $this->client->sendRequest("/v1/wallet/newAddress", $params, $headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function scanAddress(array $params,array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/scan", $params,$headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function changeWalletLabel(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/update", $params, $headers);
    }

    /**
     * @param string $queryString
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function walletBalance(string $queryString)
    {
        return $this->client->sendRequest("/v1/wallet/balance?" . $queryString, [], [], "GET");
    }

    /**
     * @param array $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function createTransaction(array $params)
    {
        return $this->client->sendRequest("/v1/wallet/transaction", $params, []);
    }

    /**
     * @param array $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function signTransaction(array $params)
    {
        return $this->client->sendRequest("/v2/wallet/transaction/sign", $params, []);

    }


    /**
     * @param array $param
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function unloadWallet(array $param, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/unload", $param, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function encryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/encrypt", $params, $headers);
    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function decryptWallet(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/decrypt", $params, $headers);

    }

    /**
     * @param array $params
     * @param array $headers
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function walletSeed(array $params, array $headers)
    {
        return $this->client->sendRequest("/v1/wallet/seed", $params, $headers);
    }

    /**
     * @param $params
     * @return array
     * @throws HttpException
     * @throws SkyCoinAPIException
     */
    public function recoverBySeed($params)
    {
        return $this->client->sendRequest("/v1/wallet/recover", $params);


    }


}