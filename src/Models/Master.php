<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 16:19
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Arrayable;
use Habil\Bcoin\Connection;
use Habil\Bcoin\Model;
use Habil\Bcoin\Serializable;

class Master extends Model
{
    use Serializable,
        Arrayable;

    /**
     * @see \Habil\Bcoin\Model::$fillable
     */
    protected $fillable = [
        'encrypted',
    ];

    /**
     * @see \Habil\Bcoin\Model::$serializableConfig
     */
    protected $serializableConfig = [
        'include_root' => FALSE,
        'exclude_id'   => FALSE,
    ];

    /**
     * Account constructor.
     *
     * @param \Habil\Bcoin\Connection $connection
     * @param array                   $attributes
     */
    public function __construct(Connection $connection, array $attributes)
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }
}