<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:14
 */

namespace Habil\Bcoin;

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
     * @return \Habil\Bcoin\Wallet
     */
    public function wallet()
    {
        return new Wallet($this->connection);
    }
}