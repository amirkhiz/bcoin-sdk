<?php

namespace Habil\Bcoin\Associations;

use Habil\Bcoin\Connection;
use Habil\Bcoin\Helper;

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
     * @var \Habil\Bcoin\Connection
     */
    private $connection;

    /**
     * @var array
     */
    private $options;

    /**
     * Create a new BelongsToAssociation
     *
     * @param string                  $name
     * @param \Habil\Bcoin\Model      $model
     * @param \Habil\Bcoin\Connection $connection
     * @param array                   $options
     */
    public function __construct($name, $model, Connection $connection, $options = [])
    {
        $this->name       = $name;
        $this->model      = $model;
        $this->options    = $options;
        $this->connection = $connection;
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

    /**
     * @return string
     */
    public function className()
    {
        if (isset($this->options['class_name'])) {
            return 'Habil\Bcoin\Models\\' . strtoupper($this->options['class_name']);
        }

        return 'Habil\Bcoin\Models\\' . strtoupper($this->name);
    }

    /**
     * @param array $attributes
     *
     * @return mixed
     */
    public function classInstance(array $attributes)
    {
        $className = $this->className();

        return new $className($this->connection, $attributes);
    }
}
