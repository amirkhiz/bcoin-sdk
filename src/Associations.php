<?php

namespace Habil\Bcoin;

use Habil\Bcoin\Associations\HasMany;
use Habil\Bcoin\Associations\BelongsTo;
use Habil\Bcoin\Associations\HasManyAssociation;
use Habil\Bcoin\Associations\BelongsToAssociation;

/**
 * Trait Associations
 *
 * @property array $associations
 * @package Habil\Bcoin
 */
trait Associations
{
    use HasMany;
    use BelongsTo;

    /**
     * Return the Has Many associations
     *
     * @return array
     */
    public function hasManyAssociations()
    {
        $associations = [];

        foreach ($this->associations as $name => $association) {
            if ($association instanceOf HasManyAssociation) {
                $associations[$name] = $association;
            }
        }

        return $associations;
    }

    /**
     * Return the Belongs To associations
     *
     * @return array
     */
    public function belongsToAssociations()
    {
        $associations = [];

        foreach ($this->associations as $name => $association) {
            if ($association instanceOf BelongsToAssociation) {
                $associations[$name] = $association;
            }
        }

        return $associations;
    }
}
