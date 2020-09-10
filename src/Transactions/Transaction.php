<?php
declare(strict_types=1);

namespace SkyCoin\Transactions;

use SkyCoin\Exception\SkyCoinTxException;

/**
 * Class Transaction
 * @package SkyCoin\Transactions
 */
class Transaction extends AbstractTx
{
    /** @var bool */
    public bool $confirmed;
    /** @var int */
    public int $height;
    /** @var int */
    public int $blockSeq;

    /**
     * Transaction constructor.
     * @param array $tx
     * @throws SkyCoinTxException
     */
    public function __construct(array $tx)
    {
        parent::__construct($tx, "txn");

        $status = $tx["status"];
        if (!is_array($status) || !$status) {
            throw new SkyCoinTxException('No "status" object in response tx');
        }

        $this->confirmed = is_bool($status["confirmed"]) ? $status["confirmed"] : false;
        $this->height = $status["height"];
        $this->blockSeq = $status["block_seq"];
    }
}
