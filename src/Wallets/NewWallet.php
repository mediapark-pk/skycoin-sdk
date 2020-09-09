<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

/**
 * Class NewWallet
 * @package SkyCoin\Wallets
 */
class NewWallet
{
    /** @var string */
    public string $filename;
    /** @var string */
    public string $version;
    /** @var string */
    public string $label;
    /** @var string */
    public string $primaryAddr;
    /** @var string */
    public string $primaryPubKey;
}
