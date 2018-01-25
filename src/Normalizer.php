<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 15:51
 */

namespace Habil\Bcoin;

use Illuminate\Support\Collection;

/**
 * Class Normalizer
 *
 * @package Habil\Bcoin
 */
class Normalizer
{
    /**
     * The model instance
     *
     * @var \Habil\Bcoin\Model
     */
    protected $model;

    /**
     * THe options array
     *
     * @var array
     */
    protected $options;

    /**
     * The root of the entity
     *
     * @var array|string
     */
    protected $root;

    /**
     * The collection roo of the entity
     *
     * @var array|string
     */
    protected $collection_root;

    /**
     * The attribute to assign
     *
     * @var string
     */
    protected $attribute_to_assign;

    /**
     * Normalizer constructor.
     *
     * @param \Habil\Bcoin\Model $model
     * @param array              $options
     */
    public function __construct(Model $model, array $options = [])
    {
        $this->model   = $model;
        $this->options = $options;
    }

    /**
     * Normalize a collection of models
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     * @throws \ReflectionException
     */
    public function model(array $attributes)
    {
        if ($this->hasSubclasses()) {
            return $this->normalizeSubclass($attributes);
        }

        return $this->normalizeModel($attributes);
    }

    /**
     * Normalize a collection of models
     *
     * @param array $attributes
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection(array $attributes)
    {
        if ($this->hasSubclasses()) {
            return $this->normalizeSubclassCollection($attributes);
        }

        return $this->normalizeCollection($attributes);
    }

    /**
     * Check to see if the entity has subclasses
     *
     * @return bool
     */
    private function hasSubclasses()
    {
        return is_array($this->root());
    }

    /**
     * Get the root of the entity
     *
     * @return array|string
     */
    private function root()
    {
        if ($this->root) {
            return $this->root;
        }

        if (isset($this->options['root'])) {
            return $this->root = $this->options['root'];
        }

        return $this->root = $this->model->serializableOptions()['root'];
    }

    /**
     * Normalize a subclass
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     */
    private function normalizeSubclass(array $attributes)
    {
        reset($attributes);

        $key = key($attributes);

        return $this->createNewModelInstance($key, $attributes[$key]);
    }

    /**
     * Create a new model
     *
     * @param string $name
     * @param array  $attributes
     *
     * @return \Habil\Bcoin\Model
     */
    private function createNewModelInstance($name, array $attributes)
    {
        $class = ucfirst($name);

        $class = "Habil\Bcoin\Models\\$class";

        $attributes = Helper::toSnakeCase($attributes);

        return new $class($this->model->connection(), $attributes);
    }

    private function normalizeSubclassCollection(array $attributes)
    {
        foreach ($attributes[(string)$this->collectionRoot()] as $key => $value) {
            if ($this->isAssociativeArray($value)) {
                $collection[] = $this->createNewModelInstance($key, $value);
            } else {
                foreach ($value as $attributes) {
                    $collection[] = $this->createNewModelInstance($key, $attributes);
                }
            }
        }

        $collection = new Collection();

        return $collection;
    }

    /**
     * Get the collection root of the entity
     *
     * @return string
     */
    private function collectionRoot()
    {
        if ($this->collection_root) {
            return $this->collection_root;
        }

        if (isset($this->options['collection_root'])) {
            return $this->collection_root = $this->options['collection_root'];
        }

        return $this->collection_root = $this->model->serializableOptions()['collection_root'];
    }

    /**
     * Check to see if the array is associative
     *
     * @param array $array
     *
     * @return bool
     */
    private function isAssociativeArray($array)
    {
        return (bool)count(array_filter(array_keys($array), 'is_string'));
    }

    /**
     * Normalize a single model
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     * @throws \ReflectionException
     */
    private function normalizeModel(array $attributes)
    {
        if ($this->includeRoot()) {
            return $this->createNewModelInstance(
                $this->model->base()->singular()->camelCase(),
                $attributes[(string)$this->root()]
            );
        } else {
            return $this->createNewModelInstance(
                $this->model->base()->singular()->camelCase(),
                $attributes
            );
        }
    }

    /**
     * Normalize a collection
     *
     * @param array $attributes
     *
     * @return \Illuminate\Support\Collection
     */
    private function normalizeCollection(array $attributes)
    {
        $collection = new Collection;
        $type       = (string)$this->collectionRoot();
        $root       = (string)$this->root();
        echo json_encode($attributes);

        if ($this->includeRoot()) {
            if ($this->isAssociativeArray($attributes[$type][$root])) {
                $collection[] = $this->createNewModelInstance($root, $attributes[$type][$root]);
            } else {
                foreach ($attributes[$type][$root] as $entity) {
                    if ($this->attributeToAssign()) {
                        $collection[] = $this->createNewModelInstance($root, [$this->attributeToAssign() => $entity]);
                    } else {
                        $collection[] = $this->createNewModelInstance($root, $entity);
                    }
                }
            }
        } else {
            if ($this->isAssociativeArray($attributes)) {
                $collection[] = $this->createNewModelInstance($root, $attributes);
            } else {
                foreach ($attributes as $entity) {
                    if ($this->attributeToAssign()) {
                        $collection[] = $this->createNewModelInstance($root, [$this->attributeToAssign() => $entity]);
                    } else {
                        $collection[] = $this->createNewModelInstance($root, $entity);
                    }
                }
            }
        }

        return $collection;
    }

    /**
     * Return the attribute to assign
     *
     * @return string
     */
    private function attributeToAssign()
    {
        if ($this->attribute_to_assign) {
            return $this->attribute_to_assign;
        }

        if (isset($this->model->serializableOptions()['attribute_to_assign'])) {
            return $this->model->serializableOptions()['attribute_to_assign'];
        }
    }

    /**
     * Check to see if the current model should include the root
     *
     * @return bool
     */
    private function includeRoot()
    {
        return $this->model->serializableOptions()['include_root'];
    }
}