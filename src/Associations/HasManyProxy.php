<?php

namespace Habil\Bcoin\Associations;

/**
 * Class HasManyProxy
 *
 * @package Habil\Bcoin\Associations
 */
class HasManyProxy
{
    /**
     * @var \Habil\Bcoin\Model
     */
    protected $parent;

    /**
     * @var string
     */
    protected $targetClass;

    /**
     * HasManyProxy constructor.
     *
     * @param \Habil\Bcoin\Model $parent
     * @param string             $targetClass
     */
    public function __construct($parent, $targetClass)
    {
        $this->parent      = $parent;
        $this->targetClass = $targetClass;
    }
}
