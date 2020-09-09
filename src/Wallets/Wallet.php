<?php


namespace SkyCoin\Wallets;


use SkyCoin\Exception\SkyCoinException;

/**
 * Class Wallet
 * @package SkyCoin\Wallets
 */
class Wallet
{
    /**
     * @var string
     */
    private string $password;
    /**
     * @var string
     */
    private string $filename;
    /**
     * @var string
     */
    private string $label;

    /**
     * Wallet constructor.
     */

    private Balance $balance;

    /**
     * Wallet constructor.
     */
    public function __construct()
    {
        $this->balance = new Balance();
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getFilename(): string
    {
        return $this->filename;
    }

    /**
     * @param string $filename
     */
    public function setFilename(string $filename): void
    {
        if (!preg_match("/.(wlt)$/i",$filename)) {
            throw new SkyCoinException("Wrong Filename");
        }
        $this->filename = $filename;
    }

    /**
     * @return string
     */
    public function getLabel(): string
    {
        return $this->label;
    }

    /**
     * @param string $label
     */
    public function setLabel(string $label): void
    {
        $this->label = $label;
    }


    /**
     * @return mixed
     */
    public function createAddress(): array
    {
        $headers = ["Content-Type" => "application/x-www-form-urlencoded"];
        $params = [
            "id" => $this->filename,
            "password" => $this->password
        ];
        $data = $this->client->sendRequest("/v1/wallet/newAddress", $params, $headers);

        if ($data->payload()->get("addresses")) {

            $response = array();
            $response["address"] = $data->payload()->get("addresses");
            return $response;
        }


    }

    /**
     * @return Balance
     */
    public function getBalance(): Balance
    {
        $data = $this->client->sendRequest("/v1/wallet/balance?id=" . $this->getFilename(), [], [], "GET");
        if ($data->payload()->get('confirmed')) {
            $this->balance->setConfirmedCoins($data->payload()->get('confirmed')['coins']);
            $this->balance->setConfirmedHours($data->payload()->get('confirmed')['hours']);
            $this->balance->setPredictedCoins($data->payload()->get('predicted')['hours']);
            $this->balance->setPredictedHours($data->payload()->get('predicted')['hours']);
            return $this->balance;
        }

    }


}