<?php
declare(strict_types=1);

namespace App\src;

/**
 * Class Transaction
 * @package App\sr
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

    /**+
     * Transaction constructor.
     * @param string $id
     */
    public function __construct(string $id)
    {
        $this->health = "OK";
        $this->id = $id;
        $this->confirmations = 0;
        $this->inputs = [];
        $this->outputs = [];
    }


}
