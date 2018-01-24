<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 18:05
 */

namespace Habil\Bcoin\Persistence;

/**
 * Trait Deletable
 *
 * @property \Habil\Bcoin\Connection $connection
 * @package Habil\Bcoin\Persistence
 * @author  Siavash Habil <amirkhiz@gmail.com>
 */
trait Deletable
{
    /**
     * Delete an existing model
     *
     * @return bool
     */
    public function delete()
    {
        $endpoint = '/api/' . $this->persistableConfig()->delete();

        if ($this->connection->delete($endpoint)) {
            $this->id = NULL;

            return TRUE;
        }

        return FALSE;
    }
}