<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 18:18
 */

namespace Habil\Bcoin\Persistence;

/**
 * Trait Storable
 *
 * @property \Habil\Bcoin\Connection $connection
 * @package Habil\Bcoin\Persistence
 * @author  Siavash Habil <amirkhiz@gmail.com>
 */
trait Storable
{
    /**
     * Create a new entity
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     */
    public function create(array $attributes)
    {
        /** @var \Habil\Bcoin\Model $model */
        $model = new static($this->connection, $attributes);

        $model->save();

        return $model;
    }

    /**
     * Update an existing entity
     *
     * @param array $attributes
     *
     * @return bool
     */
    public function update(array $attributes)
    {
        $this->fill($attributes);

        return $this->save();
    }

    /**
     * Save the current entity
     *
     * @return bool
     */
    public function save()
    {
        if ($this->validate()) {
            if ($this->isNewEntity()) {
                return $this->createNewEntityRequest();
            }

            return $this->updateExistingEntityRequest();
        }

        return FALSE;
    }

    /**
     * Is this a new entity?
     *
     * @return bool
     */
    private function isNewEntity()
    {
        return !isset($this->attributes['id']);
    }

    /**
     * Create a new entity request
     *
     * @return bool
     */
    private function createNewEntityRequest()
    {
        $endpoint = '/api/' . $this->persistableConfig()->create();

        $this->id = $this->connection->post($endpoint, $this->toJson());

        return TRUE;
    }

    /**
     * Update an existing request
     *
     * @return bool
     */
    private function updateExistingEntityRequest()
    {
        $endpoint = '/api/' . $this->persistableConfig()->update();

        $this->connection->put($endpoint, $this->toJson());

        return TRUE;
    }
}