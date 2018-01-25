<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 18:13
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Associations;
use Habil\Bcoin\Connection;
use Habil\Bcoin\Model;
use Habil\Bcoin\Persistence\Persistable;
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
    use Findable, Serializable, Associations, Persistable;

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
        'include_root' => FALSE,
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

        $this->state();
        $this->master();
        $this->account();
    }

    private function state()
    {
        $this->belongsTo(
            'state',
            [
                'serialize'        => TRUE,
                'serializable_key' => 'state',
            ]
        );
    }

    private function master()
    {
        $this->belongsTo(
            'master',
            [
                'serialize'        => TRUE,
                'serializable_key' => 'master',
            ]
        );
    }

    private function account()
    {
        $this->belongsTo(
            'account',
            [
                'serialize'        => TRUE,
                'serializable_key' => 'account',
            ]
        );
    }
}