<?php

namespace Habil\Bcoin\Associations;

use Habil\Bcoin\Model;

/**
 * Class HasManyAssociation
 *
 * @package Habil\Bcoin\Associations
 */
class HasManyAssociation
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \Habil\Bcoin\Model
     */
    private $model;

    /**
     * @var array
     */
    private $options;

    /**
     * Create a new HasManyAssociation
     *
     * @param string             $name
     * @param \Habil\Bcoin\Model $model
     * @param array              $options
     */
    public function __construct($name, Model $model, array $options = [])
    {
        $this->name    = $name;
        $this->model   = $model;
        $this->options = $options;
    }

    /**
     * @param \Habil\Bcoin\Model $parent
     *
     * @return \Habil\Bcoin\Associations\HasManyProxy
     */
    public function proxy(Model $parent)
    {
        return new HasManyProxy($parent, $this->targetClass());
    }

    /**
     * @return string
     */
    public function targetClass()
    {
        if (isset($this->options['target_class'])) {
            return $this->options['target_class'];
        }

        return $this->inferTargetClass();
    }

    /**
     * @return string
     */
    private function inferTargetClass()
    {
        return 'Habil\\Bcoin\\Models\\' . ucfirst($this->name);
    }
}
