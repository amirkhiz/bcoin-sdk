<?php

namespace Habil\Bcoin\Associations;

/**
 * Trait BelongsTo
 *
 * @property array $associations
 * @package Habil\Bcoin\Associations
 */
trait BelongsTo
{
    /**
     * Create a new BelongsToAssociation
     *
     * @param string $name
     * @param array  $options
     *
     * @return void
     */
    public function belongsTo($name, $options = [])
    {
        $association = new BelongsToAssociation($name, $this, $this->connection, $options);

        $this->associations[$name] = $association;
    }
}
