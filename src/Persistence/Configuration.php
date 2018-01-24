<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 14:18
 */

namespace Habil\Bcoin\Persistence;

/**
 * Trait Configuration
 *
 * @property array $persistableConfig
 * @package Habil\Bcoin\Persistence
 */
trait Configuration
{
    /**
     * Return an instance of the Options object
     *
     * @return \Habil\Bcoin\Persistence\Options
     */
    public function persistableConfig()
    {
        return new Options($this, $this->persistableConfig);
    }
}