<?php
declare(strict_types=1);

namespace SkyCoin\Blocks;

use SkyCoin\Exception\SkyCoinBlockException;

/**
 * Class Block
 * @package SkyCoin\Blocks
 */
class Block
{
    /** @var int */
    public int $seq;
    /** @var string */
    public string $blockHash;
    /** @var string */
    public string $prevBlockHash;
    /** @var int */
    public int $timeStamp;
    /** @var int */
    public int $fee;
    /** @var int */
    public int $version;
    /** @var string */
    public string $txBodyHash;
    /** @var string */
    public string $uxHash;
    /** @var array */
    public array $txs;
    /** @var int */
    public int $size;
    /** @var array */
    public array $raw;

    /**
     * Block constructor.
     * @param array $block
     * @throws SkyCoinBlockException
     */
    public function __construct(array $block)
    {
        $this->raw = $block;
        $headers = $block["header"];
        if (!is_array($headers) || !$headers) {
            throw new SkyCoinBlockException('Block response is missing "header" object');
        }

        $txs = $block["body"]["txns"];
        if (!is_array($txs)) {
            throw new SkyCoinBlockException('Block response is missing "transactions" list');
        }

        $this->seq = $headers["seq"];
        $this->blockHash = $headers["block_hash"];
        $this->prevBlockHash = $headers["previous_block_hash"];
        $this->timeStamp = $headers["timestamp"];
        $this->fee = $headers["fee"];
        $this->version = $headers["version"];
        $this->txBodyHash = $headers["tx_body_hash"];
        $this->uxHash = $headers["ux_hash"];
        $this->txs = [];
        $this->size = $block["size"];

        foreach ($txs as $tx) {
            if (isset($tx["txid"]) && is_string($tx["txid"]) && preg_match('/^[a-f0-9]{64}$/i', $tx["txid"])) {
                $this->txs[] = $tx["txid"];
            }
        }
    }
}
