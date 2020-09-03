<?php


namespace SkyCoin;

use SkyCoin\API\Generic;
use SkyCoin\API\Wallet\Wallet;
use SkyCoin\HttpClient;

class SkyCoin
{
    /** @var string */
    private string $ip;
    /** @var int */
    private ?int $port = NULL;
    /** @var string */
    private string $username;
    /** @var string */
    private string $password;

    /** @var Generic */
    private $generic;

    /**
     * @var Wallet
     */
    private Wallet $wallet;

    /**
     * SkyCoin constructor.
     * @param Generic $generic
     */
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "")
    {

        $httpClient = new HttpClient($ip, $port, $username, $password);
        $this->generic = new Generic($httpClient);
        $this->wallet = new Wallet($httpClient);
    }

    /**
     * @return \SkyCoin\Generic
     */
    public function generic(): Generic
    {
        return $this->generic;
    }

    /**
     * @return \SkyCoin\Wallet
     */
    public function wallet(): Wallet
    {
        return $this->wallet;
    }


}