<?php

namespace Habil\Bcoin\Associations;

/**
 * Trait HasMany
 *
 * @property array $associations
 */
trait HasMany
{
    /**
     * @param $name
     * @param $options
     */
    public function hasMany($name, array $options = [])
    {
        $association = new HasManyAssociation($name, $this, $options);

        $this->associations[$name] = $association->proxy($this);
    }
}
