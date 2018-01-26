<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 26.01.2018
 * Time: 16:59
 */

namespace Habil\Bcoin\Models;

use Habil\Bcoin\Arrayable;
use Habil\Bcoin\Associations;
use Habil\Bcoin\Connection;
use Habil\Bcoin\Model;
use Habil\Bcoin\Normalizer;
use Habil\Bcoin\Querying\Findable;
use Habil\Bcoin\Serializable;

class Transaction extends Model
{
    use Findable,
        Serializable,
        Associations,
        Arrayable;

    /**
     * @see \Habil\Bcoin\Model::$fillable
     */
    protected $fillable = [
        'hash',
        'witness_hash',
        'fee',
        'rate',
        'mtime',
        'height',
        'block',
        'time',
        'index',
        'version',
        'flag',
        'locktime',
        'confirmations',
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

    public function __construct(Connection $connection, array $attributes = [])
    {
        parent::__construct($connection);

        $this->fill($attributes);
    }

    /**
     * Find a single entity by it's id
     *
     * @param mixed $address
     *
     * @return \Illuminate\Support\Collection
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function findByAddress($address)
    {
        $endpoint = "/tx/address/{$address}";

        $response = $this->connection->get($endpoint);

        $normalizer = new Normalizer($this);

        return $normalizer->collection(json_decode($response->getBody(), TRUE));
    }
}