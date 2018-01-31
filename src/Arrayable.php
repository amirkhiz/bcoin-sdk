<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 26.01.2018
 * Time: 18:16
 */

namespace Habil\Bcoin;

use Habil\Bcoin\Meta\Helper;
use Illuminate\Support\Str;

trait Arrayable
{
    /**
     * Return model attributes and relations in array format
     * @return array
     */
    public function toArray()
    {
        return array_merge($this->attributesToArray(), $this->relationsToArray());
    }

    /**
     * Get the model's relationships in array form.
     *
     * @return array
     */
    public function relationsToArray()
    {
        $attributes = [];

        foreach ($this->getArrayableRelations() as $key => $value) {
            // If the values use the Arrayable trait we can just call this
            // toArray method on the instances which will convert both models and
            // collections to their proper array form and we'll set the values.
            if (array_key_exists('Habil\Bcoin\Arrayable', class_uses($value))) {
                $relation = $value->toArray();
            }

            // If the value is null, we'll still go ahead and set it in this list of
            // attributes since null is used to represent empty relationships if
            // if it a has one or belongs to type relationships on the models.
            elseif (is_null($value)) {
                $relation = $value;
            }

            // we will snake case this key so that the relation attribute is snake cased in this returned
            // array to the developers, making this consistent with attributes.
            $key = Str::snake($key);

            // If the relation value has been set, we will set it on this attributes
            // list for returning. If it was not arrayable or null, we'll not set
            // the value on the array because it is some type of invalid value.
            if (isset($relation) || is_null($value)) {
                $attributes[$key] = $relation;
            }

            unset($relation);
        }

        return $attributes;
    }

    /**
     * Get an attribute array of all arrayable relations.
     *
     * @return array
     */
    protected function getArrayableRelations()
    {
        return $this->relations;
    }

    /**
     * Convert the model's attributes to an array.
     *
     * @return array
     */
    public function attributesToArray()
    {
        return Helper::toCamelCase($this->attributes());
    }
}