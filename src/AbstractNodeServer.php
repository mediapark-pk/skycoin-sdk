<?php
declare(strict_types=1);

namespace SkyCoin;

use \App\src\Transaction;
use App\Coins\Wallets\Wallet;
use App\Models\Arrays\MatchedAddressesArray;
use App\User\User;

/**
 * Class AbstractNodeServer
 * @package App\Coins\Nodes
 */
abstract class AbstractNodeServer
{
    public const SPEND_REQUIRE_PAYER = null;
    public const SPEND_MAX_PAYEES = null;
    public const DEFAULT_MAX_ADDRESSES_LIMIT = 1000;

    /** @var \App */
    protected $app;
    /** @var Node */
    protected $node;
    /** @var null|Wallet */
    protected $wallet;


    /**
     * AbstractNodeServer constructor.
     * @param Node $node
     * @throws \Comely\AppKernel\Exception\BootstrapException
     */
    public function __construct(Node $node)
    {
        $this->app = \App::getInstance();
        $this->node = $node;
    }

    /**
     * @param string $message
     * @param int|null $code
     * @return \AppException
     */
    final public function exception(string $message, ?int $code = null): \AppException
    {
        return new \AppException(sprintf('%s node #%d: %s', $this->node->coin, $this->node->id, $message), $code);
    }

    /**
     * @throws \AppException
     */
    final public function __sleep()
    {
        throw $this->exception('server instance cannot be serialized');
    }

    /**
     * @return array
     */
    final public function __debugInfo(): array
    {
        return [sprintf('%s node %d server', $this->node->coin, $this->node->id)];
    }

    /**
     * @param Wallet $wallet
     * @return AbstractNodeServer
     */
    public function wallet(Wallet $wallet): self
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @param User $user
     * @param string $label
     * @return Wallet
     */
    abstract public function allocateWallet(User $user, string $label): Wallet;

    /**
     * @return void
     */
    abstract public function ping(): void;

    /**
     * @param null|string $password
     * @return string
     */
    abstract public function createAddress(?string $password = null): string;

    /**
     * @param string $addr
     * @return mixed
     */
    //abstract public function address(string $addr);

    /**
     * @param string $addr
     * @return bool
     */
    abstract public function isValidAddress(string $addr): bool;

    /**
     * @param string $txId
     * @return Transaction
     */
    abstract public function transaction(string $txId): Transaction;

    /**
     * @param int|null $confirmations
     * @return null|string
     */
    abstract public function walletBalance(?int $confirmations = 0): ?string;

    /**
     * @param int|null $confirmations
     * @param string|null $units
     * @param string|null $address
     * @return string
     */
    abstract public function balance(?int $confirmations = null, ?string $units = null, ?string $address = null): string;

    /**
     * @param array $inputs
     * @param array $outputs
     * @param string|null $units
     * @param string|null $fee
     * @param string|null $memo
     * @return string
     */
    abstract public function send(array $inputs, array $outputs, ?string $units = null, ?string $fee = null, ?string $memo = null): string;

    /**
     * @param Transaction $transaction
     * @param MatchedAddressesArray|null $matchedAddresses
     * @param bool $reIndex
     * @return bool
     */
    abstract public function archiveTx(Transaction $transaction, ?MatchedAddressesArray $matchedAddresses = null, bool $reIndex = true): bool;
}
