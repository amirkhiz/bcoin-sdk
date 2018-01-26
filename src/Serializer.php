<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 15:03
 */

namespace Habil\Bcoin;

/**
 * Class Serializer
 *
 * @package Habil\Bcoin
 */
class Serializer
{
    /**
     * @var \Habil\Bcoin\Model
     */
    private $model;

    /**
     * @var array
     */
    private $options;

    /**
     * Create a new Serializer.
     *
     * @param array $options
     *
     * @return void
     */
    public function __construct(array $options)
    {
        $this->options = $options;
    }

    /**
     * @param \Habil\Bcoin\Model $model
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function serialize(Model $model)
    {
        $this->model = $model;

        if ($this->includeRoot()) {
            return $this->serializeWithRoot();
        }

        return $this->serializeWithoutRoot();
    }

    /**
     * Check to see if the current model should include the root
     *
     * @return bool
     */
    private function includeRoot()
    {
        return $this->options['include_root'];
    }

    /**
     * Return the root of the model
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function root()
    {
        if (isset($this->options['root'])) {
            return (string)$this->options['root'];
        }

        return (string)$this->model->base()->lowercase()->singular()->camelcase();
    }

    /**
     * Serialize the model with the root
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function serializeWithRoot()
    {
        return json_encode([$this->root() => $this->buildAttributesArray()]);
    }

    /**
     * Serialize the model without the root
     *
     * @return string
     */
    private function serializeWithoutRoot()
    {
        return json_encode($this->buildAttributesArray());
    }

    /**
     * Build the attributes array
     *
     * @return array
     */
    private function buildAttributesArray()
    {
        return Helper::toCamelCase($this->cleanedAttributes());
    }

    /**
     * Return the cleaned attributes
     *
     * @return array
     */
    private function cleanedAttributes()
    {
        return $this->attributes();
    }

    /**
     * Get and format the model attributes
     *
     * @return array
     */
    private function attributes()
    {
        $attributes = [];

        foreach ($this->model->attributes() as $name => $attribute) {
            if ($attribute instanceof \DateTime) {
                $attributes[$name] = $attribute->format('Y-m-d\TH:i:s\Z');
            } else {
                $attributes[$name] = $attribute;
            }
        }

        foreach ($this->options['additional_methods'] as $additional_method) {
            $attributes = array_merge(
                $attributes,
                [
                    $additional_method => json_decode($this->model->$additional_method()->toJson()),
                ]
            );
        }

        if (array_key_exists('Habil\Bcoin\Associations', class_uses($this->model))) {
            foreach ($this->model->belongsToAssociations() as $name => $association) {
                if ($association->serialize() && ($belongsToModel = $this->belongsToValue($this->model, $name))) {
                    $attributes = array_merge(
                        $attributes,
                        [
                            $association->serializableKey() => $belongsToModel->toArray(),
                        ]
                    );
                }
            }
            //TODO: Implement HasMany relation attributes
        }

        return $attributes;
    }

    /**
     * Get the id of the associated entity
     *
     * @param Model  $model
     * @param string $name
     *
     * @return string
     */
    private function belongsToValue(Model $model, $name)
    {
        try {
            $value = $model->{$name};

            if (!is_null($value) && isset($value->id)) {
                return $value->id;
            }

            return $value;
        } catch (\Exception $exception) {
            return NULL;
        }
    }
}