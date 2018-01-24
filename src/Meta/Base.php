<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 17:26
 */

namespace Habil\Bcoin\Meta;

use Habil\Bcoin\Model;

class Base
{
    /**
     * The ReflectionClass instance
     *
     * @var \ReflectionClass
     */
    protected $reflection;

    /**
     * The class to inspect.
     *
     * @param \Habil\Bcoin\Model $model
     *
     * @throws \ReflectionException
     */
    public function __construct(Model $model)
    {
        $this->reflection = new \ReflectionClass($model);
    }

    /**
     * Convert the name to lowercase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function lowercase()
    {
        return $this->getNameInstance()->lowercase();
    }

    /**
     * Convert the name to uppercase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function uppercase()
    {
        return $this->getNameInstance()->uppercase();
    }

    /**
     * Convert the name to plural
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function plural()
    {
        return $this->getNameInstance()->plural();
    }

    /**
     * Convert the name to singular
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function singular()
    {
        return $this->getNameInstance()->singular();
    }

    /**
     * Convert the name to camelcase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function camelcase()
    {
        return $this->getNameInstance()->camelcase();
    }

    /**
     * Create new Name instance
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    protected function getNameInstance()
    {
        return new Name($this->reflection->getShortName());
    }
}