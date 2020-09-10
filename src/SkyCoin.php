<?php
declare(strict_types=1);

namespace SkyCoin;

use SkyCoin\Blocks\Blocks;
use SkyCoin\Transactions\TxFactory;
use SkyCoin\Wallets\WalletsFactory;

/**
 * Class SkyCoin
 * @package SkyCoin
 */
class SkyCoin
{
    /** @var HttpClient */
    private HttpClient $httpClient;
    /** @var WalletsFactory */
    private WalletsFactory $walletFactory;
    /** @var TxFactory */
    private TxFactory $txFactory;
    /** @var Blocks */
    private Blocks $blocks;

    /**
     * SkyCoin constructor.
     * @param string $ip
     * @param int|null $port
     * @param string|null $username
     * @param string|null $password
     * @param bool $https
     */
    public function __construct(string $ip, ?int $port = NULL, ?string $username = "", ?string $password = "", bool $https = false)
    {
        $this->httpClient = new HttpClient($ip, $port, $username, $password, $https);
        $this->walletFactory = new WalletsFactory($this);
        $this->txFactory = new TxFactory($this);
        $this->blocks = new Blocks($this);
    }

    /**
     * @return array
     * @throws Exception\SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function healthCheck(): array
    {
        return $this->httpClient->sendRequest("/v1/health");
    }

    /**
     * @return HttpClient
     */
    public function httpClient(): HttpClient
    {
        return $this->httpClient;
    }

    /**
     * @return WalletsFactory
     */
    public function wallets(): WalletsFactory
    {
        return $this->walletFactory;
    }

    /**
     * @return TxFactory
     */
    public function txs(): TxFactory
    {
        return $this->txFactory;
    }

    /**
     * @return Blocks
     */
    public function blocks(): Blocks
    {
        return $this->blocks;
    }
}
