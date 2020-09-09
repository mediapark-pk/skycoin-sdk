<?php
declare(strict_types=1);

namespace SkyCoin\Blocks;

use SkyCoin\SkyCoin;

/**
 * Class Blocks
 * @package SkyCoin\Blocks
 */
class Blocks
{
    /** @var SkyCoin */
    private SkyCoin $skyCoin;

    /**
     * Blocks constructor.
     * @param SkyCoin $sc
     */
    public function __construct(SkyCoin $sc)
    {
        $this->skyCoin = $sc;
    }

    /**
     * @param int $height
     * @return Block
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     * @throws \SkyCoin\Exception\SkyCoinBlockException
     */
    public function getByHeight(int $height): Block
    {
        return $this->getBlock("seq", $height);
    }

    /**
     * @param string $hash
     * @return Block
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     * @throws \SkyCoin\Exception\SkyCoinBlockException
     */
    public function getByHash(string $hash): Block
    {
        if (!is_string($hash) && !preg_match('/^[a-f0-9]{64}$/i', $hash)) {
            throw new \InvalidArgumentException('Invalid block hash');
        }

        return $this->getBlock("hash", $hash);
    }

    /**
     * @param string $prop
     * @param $value
     * @return Block
     * @throws \Comely\Http\Exception\HttpException
     * @throws \SkyCoin\Exception\SkyCoinAPIException
     * @throws \SkyCoin\Exception\SkyCoinBlockException
     */
    private function getBlock(string $prop, $value): Block
    {
        $block = $this->skyCoin->httpClient()->sendRequest(sprintf("/v1/block?%s=%s", $prop, $value));
        return new Block($block);
    }
}
