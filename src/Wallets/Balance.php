<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

/**
 * Class Balance
 * @package SkyCoin\Wallets
 */
class Balance
{
    /** @var int */
    public int $confirmedCoins;
    /** @var int */
    public int $confirmedHours;
    /** @var int */
    public int $predictedCoins;
    /** @var int */
    public int $predictedHours;
}
