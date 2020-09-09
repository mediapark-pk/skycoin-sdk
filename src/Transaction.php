<?php
declare(strict_types=1);

namespace SkyCoin;


/**
 * Class Transaction
 * @package App\Coins\Wallets
 * @property null|int $cached
 * @property null|int $cachedOn
 * @property null|TokenTransfer $tokenTransfer
 * @property null|StellarTx $stellarTx
 * @property null|CardanoTx $cardanoTx
 * @property null|string errorMessage
 * @property null|array $ddkTx
 * @property null|bool $fydStakeTx
 * @property null|array $btsTx
 */
class Transaction
{
    /** @var null|string */
    public $health;
    /** @var string */
    public $id;
    /** @var null|int */
    public $block;
    /** @var int */
    public $confirmations;
    /** @var array */
    public $inputs;
    /** @var array */
    public $outputs;
    /** @var null|string */
    public $fee;
    /** @var null|string */
    public $totalIn;
    /** @var null|string */
    public $totalOut;
    /** @var int */
    public $time;
    /**@var array */
    public $unconfirmedTxids;
    /**
     * Transaction constructor.
     * @param string $id
     */
    public function __construct(string $id = null)
    {
        $this->health = "OK";
        $this->id = $id;
        $this->confirmations = 0;
        $this->inputs = [];
        $this->outputs = [];
        $this->unconfirmedTxids = [];
    }
}
