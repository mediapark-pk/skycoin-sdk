<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

use SkyCoin\Exception\SkyCoinWalletException;
use SkyCoin\SkyCoin;
use SkyCoin\Validator;

/**
 * Class Wallet
 * @package SkyCoin\Wallets
 */
class Wallet
{
    /** @var SkyCoin */
    private SkyCoin $skyCoin;
    /** @var string */
    private string $filename;
    /** @var string|null */
    private ?string $password = null;
    /** @var Balance|null */
    private ?Balance $balance = null;

    /**
     * Wallet constructor.
     * @param SkyCoin $skyCoin
     * @param string $walletFilename
     * @param string|null $password
     * @throws SkyCoinWalletException
     */
    public function __construct(SkyCoin $skyCoin, string $walletFilename, ?string $password = null)
    {
        if (!Validator::isValidWalletFilename($walletFilename)) {
            throw new SkyCoinWalletException('Invalid wallet identifier/filename');
        }

        $this->skyCoin = $skyCoin;
        $this->filename = $walletFilename;
        if ($password) {
            $this->setPassword($password);
        }
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
}
