<?php
declare(strict_types=1);

namespace SkyCoin\Transactions;

use SkyCoin\Exception\SkyCoinTxException;

/**
 * Class AbstractTx
 * @package SkyCoin\Transactions
 */
abstract class AbstractTx
{
    /** @var string */
    public string $txId;
    /** @var int|null */
    public ?int $time;
    /** @var int */
    public int $length;
    /** @var int */
    public int $type;
    /** @var string */
    public string $innerHash;
    /** @var string */
    public string $fee;
    /** @var array */
    public array $sigs;
    /** @var array */
    public array $inputs;
    /** @var array */
    public array $outputs;
    /** @var array */
    public array $raw;

    /**
     * AbstractTx constructor.
     * @param array $tx
     * @param string $txnProp
     * @throws SkyCoinTxException
     */
    public function __construct(array $tx, string $txnProp = "txn")
    {
        $this->raw = $tx;

        $txn = $tx[$txnProp];
        if (!is_array($txn) || !$txn) {
            throw new SkyCoinTxException(sprintf('No "%s" object in response tx', $txnProp));
        }

        $this->txId = $txn["txid"];
        $this->time = $tx["time"] ?? null;
        $this->length = $txn["length"];
        $this->type = $txn["type"];
        $this->innerHash = $txn["inner_hash"];
        $this->fee = strval($txn["fee"]);
        $this->sigs = $txn["sigs"] ?? [];
        $this->inputs = $txn["inputs"] ?? [];
        $this->outputs = $txn["outputs"] ?? [];
    }
}
