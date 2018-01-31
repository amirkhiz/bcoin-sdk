<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:14
 */

namespace Habil\Bcoin;

use Habil\Bcoin\Models\Account;
use Habil\Bcoin\Models\Transaction;
use Habil\Bcoin\Models\Wallet;

class Bcoin
{
    /**
     * The HTTP Connection
     *
     * @var \Habil\Bcoin\Connection
     */
    protected $connection;

    /**
     * Create a new instance of CapsuleCRM
     *
     * @param \Habil\Bcoin\Connection $connection
     *
     * @return void
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Return a new Wallet Model
     *
     * @return \Habil\Bcoin\Models\Wallet
     */
    public function wallet()
    {
        return new Wallet($this->connection);
    }

    /**
     * Return a new Account Model
     *
     * @return \Habil\Bcoin\Models\Account
     */
    public function account()
    {
        return new Account($this->connection);
    }

    /**
     * Return a new Transaction Model
     *
     * @return \Habil\Bcoin\Models\Transaction
     */
    public function transaction()
    {
        return new Transaction($this->connection);
    }
}