<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:18
 */

namespace Habil\Bcoin\Querying;

use Habil\Bcoin\Normalizer;

trait FindAll
{
    /**
     * Return all entities of the current model
     *
     * @param array $params
     *
     * @return \Illuminate\Support\Collection
     */
    public function all($params = [])
    {
        $endpoint = '/api/' . $this->queryableOptions()->plural();

        $response = $this->connection->get($endpoint, $params);

        $normalizer = new Normalizer($this);

        return $normalizer->collection($response->json());
    }
}