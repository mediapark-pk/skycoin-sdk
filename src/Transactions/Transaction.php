<?php
declare(strict_types=1);

namespace SkyCoin\Transactions;

use SkyCoin\Exception\SkyCoinTxException;

/**
 * Class Transaction
 * @package SkyCoin\Transactions
 */
class Transaction
{
    /** @var string */
    public string $txId;
    /** @var int */
    public int $time;
    /** @var bool */
    public bool $confirmed;
    /** @var int */
    public int $height;
    /** @var int */
    public int $blockSeq;
    /** @var int */
    public int $length;
    /** @var int */
    public int $type;
    /** @var string */
    public string $innerHash;
    /** @var int */
    public int $fee;
    /** @var array */
    public array $sigs;
    /** @var array */
    public array $inputs;
    /** @var array */
    public array $outputs;

    /**
     * Transaction constructor.
     * @param array $tx
     * @throws SkyCoinTxException
     */
    public function __construct(array $tx)
    {
        $status = $tx["status"];
        if (!is_array($status) || !$status) {
            throw new SkyCoinTxException('No "status" object in response tx');
        }

        $txn = $tx["txn"];
        if (!is_array($txn) || !$txn) {
            throw new SkyCoinTxException('No "txn" object in response tx');
        }

        $this->txId = $txn["txid"];
        $this->time = $tx["time"];
        $this->confirmed = is_bool($status["confirmed"]) ? $status["confirmed"] : false;
        $this->height = $status["height"];
        $this->blockSeq = $status["block_seq"];
        $this->length = $txn["length"];
        $this->type = $txn["type"];
        $this->innerHash = $txn["inner_hash"];
        $this->fee = $txn["fee"];
        $this->sigs = $txn["sigs"] ?? [];
        $this->inputs = $txn["inputs"] ?? [];
        $this->outputs = $txn["outputs"] ?? [];
    }
}
