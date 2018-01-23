<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:13
 */

namespace Habil\Bcoin;

use Habil\Bcoin\Querying\Findable;

class Wallet extends Model
{
    use Findable, Serializable;

    /**
     * Create a new instance of the Wallet model
     *
     * @param \Habil\Bcoin\Connection $connection
     * @param array                   $attributes
     */
    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }
}