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
        'wid',
        'id',
        'hash',
        'witness_hash',
        'fee',
        'rate',
        'mtime',
        'height',
        'block',
        'time',
        'date',
        'index',
        'version',
        'flag',
        'locktime',
        'confirmations',
        'size',
        'virtual_size',
        'tx',
    ];

    /**
     * @see \Habil\Bcoin\Model::$serializableConfig
     */
    protected $serializableConfig = [
        'include_root'       => FALSE,
        'include_subclasses' => ['inputs', 'outputs'],
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

        //Init relations
        $this->input();
        $this->output();
    }

    /**
     * Find a transactions that related to this address
     *
     * @param string $address
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

    /**
     * Find a single transaction with hash code
     *
     * @param  string $walletId
     * @param string  $hash
     *
     * @return \Habil\Bcoin\Model
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function findByHash($walletId, $hash)
    {
        $endpoint = "wallet/{$walletId}/tx/{$hash}";

        $response = $this->connection->get($endpoint);

        $normalizer = new Normalizer($this);

        return $normalizer->model(json_decode($response->getBody(), TRUE));
    }

    private function input()
    {
        $this->belongsTo(
            'inputs',
            [
                'serialize'        => TRUE,
                'serializable_key' => 'inputs',
                'class_name'       => 'Input',
            ]
        );
    }

    private function output()
    {
        $this->belongsTo(
            'outputs',
            [
                'serialize'        => TRUE,
                'serializable_key' => 'outputs',
                'class_name'       => 'Output',
            ]
        );
    }
}