<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 16:19
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Model;
use Habil\Bcoin\Serializable;

class Master extends Model
{
    use Serializable;

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
     * @param array $attributes
     */
    public function __construct(array $attributes)
    {
        $this->fill($attributes);
    }
}