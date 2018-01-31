<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 30.01.2018
 * Time: 15:20
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Arrayable;
use Habil\Bcoin\Associations;
use Habil\Bcoin\Connection;
use Habil\Bcoin\Helper;
use Habil\Bcoin\Model;
use Habil\Bcoin\Serializable;

class Input extends Model
{
    use Associations,
        Serializable,
        Arrayable;

    /**
     * @see \Habil\Bcoin\Model::$fillable
     */
    protected $fillable = [
        'witness',
        'sequence',
        'value',
        'address',
        'prevout',
        'coin',
        'script',
        'path',
    ];

    /**
     * @see \Habil\Bcoin\Model::$serializableConfig
     */
    protected $serializableConfig = [
        'include_root' => 'inputs',
    ];

    /**
     * @see \Habil\Bcoin\Validating::$rules
     */
    protected $rules = [
    ];

    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);

        $this->belongsTo('transaction', ['class_name' => 'Transaction']);
    }
}