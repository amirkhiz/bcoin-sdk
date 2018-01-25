<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:17
 */

namespace Habil\Bcoin\Querying;
use Habil\Bcoin\Normalizer;

/**
 * Trait FindOne
 *
 * @property \Habil\Bcoin\Connection $connection
 * @package Habil\Bcoin\Querying
 */
trait FindOne
{
    /**
     * Find a single entity by it's id
     *
     * @param int $id
     *
     * @return \Habil\Bcoin\Model
     * @throws \ReflectionException
     */
    public function find($id)
    {
        $endpoint = '/' . $this->queryableOptions()->singular() . '/' . $id;

        $response = $this->connection->get($endpoint);

        $normalizer = new Normalizer($this);

        return $normalizer->model($response->json());
    }
}