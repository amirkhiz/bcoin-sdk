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
 */
trait Storable
{
    /**
     * Create a new entity
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model|\Habil\Bcoin\Persistence\Storable
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function create(array $attributes)
    {
        $this->fill($attributes);

        $this->save();

        return $this;
    }

    /**
     * Update an existing entity
     *
     * @param array $attributes
     *
     * @return bool
     * @throws \Habil\Bcoin\Exceptions\BcoinException
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
     * @throws \Habil\Bcoin\Exceptions\BcoinException
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
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function createNewEntityRequest()
    {
        //TODO: Add catch exception for Bcoin exceptions
        $endpoint = '/' . $this->persistableConfig()->create();

        if ($this->serializableConfig['exclude_id']) {
            $this->connection->put($endpoint, $this->toJson());
        } else {
            $this->id = $this->connection->put($endpoint, $this->toJson());
        }

        return TRUE;
    }

    /**
     * Update an existing request
     *
     * @return bool
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function updateExistingEntityRequest()
    {
        //TODO: Add catch exception for Bcoin exceptions
        $endpoint = '/' . $this->persistableConfig()->update();

        $this->connection->put($endpoint, $this->toJson());

        return TRUE;
    }
}