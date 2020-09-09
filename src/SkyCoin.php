<?php
declare(strict_types=1);

namespace SkyCoin;

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
}
