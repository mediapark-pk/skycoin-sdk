<?php
declare(strict_types=1);

namespace SkyCoin\Wallets;

use SkyCoin\Exception\SkyCoinTxException;
use SkyCoin\Transactions\AbstractTx;

/**
 * Class PreparedTx
 * @package SkyCoin\Wallets
 */
class PreparedTx extends AbstractTx
{
    /** @var string */
    public string $encodedTx;

    /**
     * PreparedTx constructor.
     * @param array $tx
     * @param string $txnProp
     * @throws SkyCoinTxException
     */
    public function __construct(array $tx, string $txnProp = "transaction")
    {
        parent::__construct($tx, $txnProp);

        $encoded = $tx["encoded_transaction"];
        if (!is_string($encoded) || !preg_match('/^[a-f0-9]+$/i', $encoded)) {
            throw new SkyCoinTxException('Invalid encoded transaction');
        }

        $this->encodedTx = $encoded;
    }
}
