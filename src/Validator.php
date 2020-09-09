<?php
declare(strict_types=1);

namespace SkyCoin;

/**
 * Class Validator
 * @package SkyCoin
 */
class Validator
{
    /**
     * @param $arg
     * @return bool
     */
    public static function isValidWalletFilename($arg): bool
    {
        if (is_string($arg) && preg_match('/^[a-z0-9]+(_[a-z0-9]+)*\.wlt$/i', $arg)) {
            return true;
        }

        return false;
    }

    /**
     * @param $arg
     * @return bool
     */
    public static function isValidAddress($arg): bool
    {
        if (is_string($arg) && preg_match('/^[a-z0-9]{30,40}$/i', $arg)) {
            return true;
        }

        return false;
    }
}
