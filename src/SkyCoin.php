<?php


namespace SkyCoin;

use SkyCoin\API\Blocks\Blocks;
use SkyCoin\API\coinSupply\coinSupply;
use SkyCoin\API\GeneralSystem\GeneralSystem;
use SkyCoin\API\Generic;

use SkyCoin\API\Network\Network;

use SkyCoin\API\KeyValueStorage\KeyValueStorage;
use SkyCoin\API\SimpleQuery\SimpleQuery;
use SkyCoin\API\Transaction\Transaction;
use SkyCoin\API\Uxout\Uxout;

use SkyCoin\API\Wallet\Wallet;
use SkyCoin\HttpClient;

/**
 * Class SkyCoin
 * @package SkyCoin
 */
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
     * @var Network
     */
    private Network $network;

    /**
     * @var GeneralSystem
     */
    private GeneralSystem $generalsystem;

    /**
     * @var SimpleQuery
     */
    private SimpleQuery $simplequery;

    /**
     * @var KeyValueStorage
     */
    private KeyValueStorage $keyvalueStorage;

    /**
     * @var Blocks
     */
    private Blocks $blocks;

    /**
     * @var Uxout
     */
    private Uxout $uxout;

    /**
     * @var coinSupply
     */
    private coinSupply $coinSupply;


    /**
     * @var Transaction
     */
    private Transaction $transaction;

    /**
     * SkyCoin constructor.
     * @param Generic $generic
     */
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "")
    {

        $httpClient = new HttpClient($ip, $port, $username, $password);
        $this->generic = new Generic($httpClient);
        $this->wallet = new Wallet($httpClient);

        $this->network = new Network($httpClient);

        $this->generalsystem = new GeneralSystem($httpClient);
        $this->simplequery = new SimpleQuery($httpClient);
        $this->keyvalueStorage = new KeyValueStorage($httpClient);
        $this->transaction = new Transaction($httpClient);
        $this->blocks = new Blocks($httpClient);
        $this->uxout = new Uxout($httpClient);
        $this->coinSupply = new coinSupply($httpClient);

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

    /**
     * @return Network
     */
    public function network(): Network
    {
        return $this->network;
    }

    /**
     * @return GeneralSystem
     */
    public function genralsystem(): GeneralSystem
    {
        return $this->generalsystem;
    }

    /**
     * @return SimpleQuery
     */
    public function simpleQuery(): SimpleQuery
    {
        return $this->simplequery;
    }

    /**
     * @return KeyValueStorage
     */
    public function keyvalueStorage(): KeyValueStorage
    {
        return $this->keyvalueStorage;
    }

    /**
     * @return Transaction
     */
    public function tranaction(): Transaction
    {
        return $this->transaction;
    }

    /**
     * @return Blocks
     */
    public function blocks(): Blocks
    {
        return $this->blocks;
    }

    /**
     * @return Uxout
     */
    public function uxout(): Uxout
    {
        return $this->uxout;
    }


    /**
     * @return coinSupply
     */
    public function coinSupply(): coinSupply
    {
        return $this->coinSupply;

    }


}