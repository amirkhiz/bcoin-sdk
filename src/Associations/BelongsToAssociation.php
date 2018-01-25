<?php

namespace Habil\Bcoin\Associations;

/**
 * Class BelongsToAssociation
 *
 * @package Habil\Bcoin\Associations
 */
class BelongsToAssociation
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
     * Create a new BelongsToAssociation
     *
     * @param string             $name
     * @param \Habil\Bcoin\Model $model
     * @param array              $options
     */
    public function __construct($name, $model, $options = [])
    {
        $this->name    = $name;
        $this->model   = $model;
        $this->options = $options;
    }

    /**
     * Determine if the association should be serialised
     *
     * @return bool
     */
    public function serialize()
    {
        if (isset($this->options['serialize'])) {
            return $this->options['serialize'];
        }

        return TRUE;
    }

    /**
     * Return the foreign key
     *
     * @return string
     */
    public function foreignKey()
    {
        if (isset($this->options['foreign_key'])) {
            return $this->options['foreign_key'];
        }

        return $this->inferForeignKey();
    }

    /**
     * The key to use when serialising this association
     *
     * @return string
     */
    public function serializableKey()
    {
        if (isset($this->options['serializable_key'])) {
            return $this->options['serializable_key'];
        }

        return $this->foreignKey();
    }

    /**
     * Infer the foreign key from the association name
     *
     * @return string
     */
    private function inferForeignKey()
    {
        return strtolower($this->name) . '_id';
    }
}
