<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

use SkyCoin\Exception\SkyCoinAPIException;
use SkyCoin\SkyCoin;

/**
 * Class WalletsFactory
 * @package SkyCoin\Wallets
 */
class WalletsFactory
{
    /** @var SkyCoin */
    private SkyCoin $skyCoin;

    /**
     * WalletsFactory constructor.
     * @param SkyCoin $skyCoin
     */
    public function __construct(SkyCoin $skyCoin)
    {
        $this->skyCoin = $skyCoin;
    }

    /**
     * @param string $seed
     * @param string $label
     * @param string $password
     * @param string $type
     * @param int $scan
     * @return NewWallet
     * @throws SkyCoinAPIException
     * @throws \Comely\Http\Exception\HttpException
     */
    public function create(string $seed, string $label, string $password, string $type = "deterministic", int $scan = 1): NewWallet
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

        $headers = [
            "Content-Type" => "application/x-www-form-urlencoded"
        ];

        $data = $this->skyCoin->httpClient()->sendRequest("/v1/wallet/create", $params, $headers, "POST");
        $meta = $data["meta"] ?? null;
        if (!is_array($meta) || !$meta) {
            throw new SkyCoinAPIException('Could not retrieve meta object for new wallet');
        }

        $newWallet = new NewWallet();
        $newWallet->label = $meta["label"];
        $newWallet->filename = $meta["filename"];
        $newWallet->version = $meta["version"];

        $primaryAddr = $data["entries"][0] ?? null;
        if (!is_array($primaryAddr) || !$primaryAddr) {
            throw new SkyCoinAPIException('Could not retrieve entries object for new wallet');
        }

        $newWallet->primaryAddr = $primaryAddr["address"];
        $newWallet->primaryPubKey = $primaryAddr["public_key"];

        return $newWallet;
    }

    /**
     * @param string $walletId
     * @return Wallet
     * @throws \SkyCoin\Exception\SkyCoinWalletException
     */
    public function get(string $walletId): Wallet
    {
        return new Wallet($this->skyCoin, $walletId);
    }
}
