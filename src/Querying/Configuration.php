<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:39
 */

namespace Habil\Bcoin\Querying;

trait Configuration
{
    /**
     * Return an instance of the Options object
     *
     * @return \Habil\Bcoin\Querying\Options
     * @throws \ReflectionException
     */
    public function queryableOptions()
    {
        return new Options($this);
    }
}