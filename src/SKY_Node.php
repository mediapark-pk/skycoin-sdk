<?php


namespace SkyCoin;


use App\Coins\Wallets\Transaction;
use App\Coins\Wallets\Wallet;
use App\Models\Arrays\MatchedAddressesArray;
use App\User\User;
use SkyCoin\SkyCoin;
use SkyCoin\API\Generic;

/**
 * Class SKY_Node
 * @package SkyCoin
 */
class SKY_Node extends AbstractNodeServer
{

    /** @var \SkyCoin\SkyCoin */
    private $_skycoin;

    /**
     * @return \SkyCoin\SkyCoin
     */
    public function skycoin(): \SkyCoin\SkyCoin
    {
        return $this->_skycoin;
    }

    /**
     * @param Wallet $wallet
     * @return $this|AbstractNodeServer
     */
    public function wallet(\App\Coins\Wallets\Wallet $wallet): AbstractNodeServer
    {
        $this->wallet = $wallet;
        return $this;
    }

    /**
     * @param bool|false $load
     * @return Wallet
     */
    public function skycoinWallet(bool $load = false): Wallet
    {
        if (!$this->wallet) {
            throw new \AppException('No wallet selected');
        }

        $wallet = $this->skycoin()->wallets()
            ->get($this->wallet->wallet);
        if ($load && !$wallet->isLoaded(true)) {
            $wallet->load();
        }

        return $wallet;
    }


    /**
     * @param array $args
     * @return Wallet
     */
    public function generateWallet(array $args): Wallet
    {
        // Make sure that server is online
        if (!$this->isOnline()) {
            throw new \AppException('Node daemon/server is not online');
        }

        try {
            $this->command([$this->_skycoin->wallet(), "createWallet"], $args);
        } catch (\Exception $e) {
            throw new \AppException(
                sprintf('Failed to ping %s node server %d', $this->node->coin, $this->node->id)
            );
        }
    }

    /**
     * @param User $user
     * @param string $label
     * @return Wallet
     */
    public function allocateWallet(User $user, string $label): Wallet
    {
        $db = $this->app->db();
        if (!$db->inTransaction()) {
            throw new \AppException('Database MUST BE in transaction mode');
        }

        if (!$this->app->dev()) {
            throw new \AppException('No new Bitcoin wallets are available');
        }

        // Check status is open
        if ($this->node->status !== 'open') {
            throw $this->exception('Node server status not open');
        } elseif (!$this->node->checksumVerified) {
            throw $this->exception('Node checksum not validated');
        }

        // Bring some random unassigned wallets
        $randomWalletsQuery = sprintf(
            "SELECT" . " * FROM `%s` WHERE `coin`='%s' AND `user` IS NULL ORDER BY RAND() LIMIT 10",
            Wallets::NAME,
            $this->node->coin
        );

        $randomWallets = $db->fetch($randomWalletsQuery, []);
        $randomWalletsCount = count($randomWallets);
        if ($randomWalletsCount < 10) {
            throw $this->exception('Cannot find minimum number of unallocated wallets');
        }

        $randomWallet = $randomWallets[mt_rand(0, ($randomWalletsCount - 1))];
        $wallet = new \App\Coins\Wallets\Wallet($randomWallet);
        $wallet->bootstrap();

        // Obtain lock
        $checksum = $wallet->private("checksum");
        if (!$checksum) {
            throw $this->exception(sprintf('pre-allocated wallet %d checksum is invalid', $wallet->id));
        }

        $lock = $wallet->lock()->obtain("checksum", $wallet->private("checksum"));
        if (!$lock) {
            throw $this->exception(sprintf('failed to obtain lock on wallet %d', $wallet->id));
        }

        // Validate wallet
        try {
            $wallet->validate();
        } catch (\AppException $e) {
            throw $this->exception($e->getMessage());
        }

        // Verify Wallet Passphrase
        try {
            $allocatingWalletOnNode = $this->skycoin()->wallets()->get($wallet->wallet);
            sleep(1);
            $allocatingWalletOnNode->load();
            sleep(2);
            $testPassphrase = $allocatingWalletOnNode->passPhrase($wallet->credentials()->password())
                ->unlock(0);
            if (!$testPassphrase) {
                throw new \AppException('Failed to unlock wallet');
            }
        } catch (\Exception $e) {
            if ($this->app->dev()) {
                $lastCommandError = $this->skycoin()->jsonRPC_client()->lastCommandError();
                if ($lastCommandError) {
                    trigger_error($lastCommandError->message, E_USER_WARNING);
                }

                trigger_error(\App::Exception2Str($e), E_USER_WARNING);
            }

            throw $this->exception(sprintf('Wallet %d could not be verified', $wallet->id));
        }

        // Allocate Wallet
        $wallet->status = 'active';
        $wallet->user = $user->id;
        $wallet->userLabel = $label;
        $wallet->userStamp = time();
        $wallet->set("checksum", $wallet->checksum());

        $update = $wallet->query()->update();
        if (!$update || $db->lastQuery()->error) {
            if ($this->app->dev() && $db->lastQuery()->error) {
                trigger_error($db->lastQuery()->error, E_USER_WARNING);
            }

            throw $this->exception(sprintf('failed to allocated wallet %d to user', $wallet->id));
        }

        // Create Primary Address
        try {
            Wallets\Addresses::create($wallet, "Primary", $user);
        } catch (\Exception $e) {
            if ($this->app->dev()) {
                trigger_error(\App::Exception2Str($e), E_USER_WARNING);
            }

            trigger_error('Failed to generate Primary address', E_USER_WARNING);
        }

        $wallet->deleteCached();
        return $wallet;
    }

    /**
     *
     */
    public function ping(): void
    {
        try {
            $this->command([$this->_skycoin->generic(), "version"]);
        } catch (\Exception $e) {
            throw new \AppException(
                sprintf('Failed to ping %s node server %d', $this->node->coin, $this->node->id)
            );
        }
    }

    /**
     * @param int $maxAttempts
     * @param int $interval
     * @return bool
     */
    public function isOnline(int $maxAttempts = 10, int $interval = 2): bool
    {
        $attempt = 0;
        while (true) {
            $attempt++;

            try {
                $this->ping();
                return true;
            } catch (\Exception $e) {
                if ($attempt > $maxAttempts) {
                    break;
                }

                sleep($interval);
            }
        }

        return false;
    }

    /**
     * @param string|null $password
     * @return string
     */
    public function createAddress(?string $password = null): string
    {
        $address = $this->command([$this->skycoinWallet(), "newAddress"]);
        if (!is_string($address) || !$address) {
            throw new \AppException('Failed to generate bitcoind address');
        }

        return $address;
    }

    /**
     * @param string $addr
     * @return bool
     */
    public function isValidAddress(string $addr): bool
    {
        return is_string($addr) && $addr ? true : false;
    }

    public function transaction(string $txId): Transaction
    {
        // TODO: Implement transaction() method.
    }

    public function walletBalance(?int $confirmations = 0): ?string
    {
        if ($this->wallet->coin === "SKY") {
            return null;
        }
        if ($this->wallet->coin === "LBTC") {
            return null;
        }

        $args = ["*", $confirmations];
        if ($this->wallet->coin === "IAN") {
            $args = null;
        } elseif ($this->wallet->coin === "FYD") {
            $args = null;
        }

        $balance = $this->command([$this->skycoinWallet(), "walletBalance"], $args);
        if (!Validator::BcAmount($balance, true)) {
            throw new \AppException('Failed to retrieve wallet balance');
        }

        return $balance;
    }

    public function balance(?int $confirmations = null, ?string $units = null, ?string $address = null): string
    {
        if ($units && $units !== $this->node->coin) {
            throw new \AppException(sprintf('%s node does not retrieve balance by units', $this->node->coin));
        }

        if ($address) {
            throw new \AppException(sprintf('%s node does not retrieve balance by address', $this->node->coin));
        }

        return $this->walletBalance($confirmations);
    }

    public function send(array $inputs, array $outputs, ?string $units = null, ?string $fee = null, ?string $memo = null): string
    {
        // TODO: Implement send() method.
    }

    public function archiveTx(Transaction $transaction, ?MatchedAddressesArray $matchedAddresses = null, bool $reIndex = true): bool
    {
        // TODO: Implement archiveTx() method.
    }

    /**
     * @param callable $callable
     * @param array|null $args
     * @return mixed
     */
    protected function command(callable $callable, ?array $args = null)
    {
        $app = \App::getInstance();
        try {
            return call_user_func_array($callable, $args ?? []);
        } catch (\Exception $e) {
            if ($app->dev()) {
                trigger_error(
                    $e instanceof \AppException ? $e->getMessage() : \App::Exception2Str($e),
                    E_USER_WARNING);
            }

            throw new \AppException(sprintf('[%s]: %s', $this->node->coin, $e->getMessage()));
            //throw new \AppException(sprintf('%s daemon command failed', $this->node->coin));
        }
    }

}