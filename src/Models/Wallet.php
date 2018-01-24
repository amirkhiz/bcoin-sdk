<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:13
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Connection;
use Habil\Bcoin\Model;
use Habil\Bcoin\Querying\Findable;
use Habil\Bcoin\Serializable;

/**
 * Class Wallet
 *
 * @package Habil\Bcoin\Models\Wallet
 * @author  Siavash Habil <amirkhiz@gmail.com>
 */
class Wallet extends Model
{
    use Findable, Serializable;

    /**
     * @see \Habil\Bcoin\Model::$fillable
     */
    protected $fillable = [
        'network',
        'wid',
        'id',
        'initialized',
        'watch_only',
        'account_depth',
        'token',
        'token_depth',
        'witness',
        'type',
        'mnemonic',
    ];

    /**
     * @see \Habil\Bcoin\Model::$serializableConfig
     */
    protected $serializableConfig = [
        'additional_methods' => ['state', 'master', 'account'],
    ];

    /**
     * @see \Habil\Bcoin\Validating::$rules
     */
    protected $rules = [
        'id' => 'required',
    ];

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