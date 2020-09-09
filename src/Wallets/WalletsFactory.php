<?php


namespace SkyCoin\Wallets;

use SkyCoin\HttpClient;
use SkyCoin\Wallets\Wallet;

/**
 * Class WalletsFactory
 * @package SkyCoin\Wallets
 */
class WalletsFactory
{
    /**
     * @var HttpClient
     */
    private HttpClient $client;

    /**
     * @var \SkyCoin\Wallets\Wallet
     */
    private Wallet $wallet;

    /**
     * Generic constructor.
     */
    public function __construct(HttpClient $client)
    {
        $this->client = $client;


    }


    /**
     * @param string $seed
     * @param string $label
     * @param string $password
     * @param string $type
     * @param int $scan
     * @return \SkyCoin\Wallets\Wallet
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function createWallet(string $seed, string $label, string $password, string $type = "deterministic", int $scan = 0): Wallet
    {
        $params = [
            "seed" => $seed,
            "label" => $label,
            "password" => $password,
            "type" => $type,
            "scan" => $scan
        ];
        if ($password) {
            $params["encrypt"] = "true";
        }
        $headers = ["Content-Type" => "application/x-www-form-urlencoded"];
        $data = $this->client->sendRequest("/v1/wallet/create", $params, $headers);
        if ($data->payload()->get('meta')) {
            $this->wallet = new Wallet();
            $this->wallet->setFilename($data->payload()->get('meta')['filename']);
            $this->wallet->setLabel($data->payload()->get('meta')['label']);
            $this->wallet->setPassword($password);
            return $this->wallet;
        }


    }


    /**
     * @return \SkyCoin\Wallets\Wallet
     * @throws \SkyCoin\Exception\SkyCoinException
     */
    public function getWallet(): Wallet
    {
        print_r($this->wallet->getFilename());
        die();
        $data = $this->client->sendRequest("/v1/wallet?id=" . $this->wallet->getFilename(), [], [], "GET");
//        $data = $this->client->sendRequest("/v1/wallet?id=" . "2020_09_09_c2af.wlt", [], [], "GET");
        if ($data->payload()->get('meta')) {
            $this->wallet = new Wallet();
            $this->wallet->setFilename($data->payload()->get('meta')['filename']);
            $this->wallet->setLabel($data->payload()->get('meta')['label']);
            $this->wallet->setPassword();
            return $this->wallet;
        }
    }
}