<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:18
 */

namespace Habil\Bcoin\Querying;

use Habil\Bcoin\Normalizer;

/**
 * Trait FindAll
 *
 * @property \Habil\Bcoin\Connection $connection
 * @package Habil\Bcoin\Querying
 */
trait FindAll
{
    /**
     * Return all entities of the current model
     *
     * @param array $params
     *
     * @return \Illuminate\Support\Collection
     * @throws \ReflectionException
     */
    public function all($params = [])
    {
        $endpoint = '/' . $this->queryableOptions()->plural();

        $response = $this->connection->get($endpoint, $params);

        $normalizer = new Normalizer($this);

        return $normalizer->collection($response->json());
    }
}