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
     * @param string $username
     * @param string $password
     * @param string $ip
     * @param int    $port
     *
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function __construct($username, $password, $ip, $port)
    {
        $this->connection = new Connection($username, $password, $ip, $port);
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