<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 16:19
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Arrayable;
use Habil\Bcoin\Associations;
use Habil\Bcoin\Connection;
use Habil\Bcoin\Model;
use Habil\Bcoin\Persistence\Persistable;
use Habil\Bcoin\Querying\Findable;
use Habil\Bcoin\Serializable;

/**
 * Class Account
 *
 * @package Habil\Bcoin\Models
 */
class Account extends Model
{
    use Serializable,
        Associations,
        Persistable,
        Findable,
        Arrayable;

    /**
     * @see \Habil\Bcoin\Model::$fillable
     */
    protected $fillable = [
        'name',
        'initialized',
        'witness',
        'watch_only',
        'type',
        'm',
        'n',
        'account_index',
        'receive_depth',
        'change_depth',
        'nested_depth',
        'lookahead',
        'receive_address',
        'nested_address',
        'change_address',
        'account_key',
        'keys',
    ];

    /**
     * @see \Habil\Bcoin\Model::$serializableConfig
     */
    protected $serializableConfig = [
        'include_root' => FALSE,
        'exclude_id'   => TRUE,
    ];

    /**
     * @see \Habil\Bcoin\Validating::$rules
     */
    protected $rules = [
        'name' => 'required',
        //TODO: Add all validation rules
    ];

    /**
     * Account constructor.
     *
     * @param \Habil\Bcoin\Connection $connection
     * @param array                   $attributes
     */
    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);

        $this->persistableConfig = [
            'create' => function () {
                return $this->createUri();
            },
        ];

        $this->queryableOptions = [
            'singular' => function () {
                return $this->singularUri();
            },
        ];

        $this->belongsTo('wallet', ['class_name' => 'Wallet']);
    }

    /**
     * Return the create uri for account
     *
     * @return string
     */
    private function createUri()
    {
        if ($this->wallet && $this->name) {
            return 'wallet/' . $this->wallet->id . '/account/' . $this->name;
        }

        return 'account';
    }

    /**
     * Return the uri to access singular account
     *
     * @return string
     */
    private function singularUri()
    {
        if ($this->wallet) {
            return 'wallet/' . $this->wallet->id . '/account';
        }

        return 'account';
    }
}