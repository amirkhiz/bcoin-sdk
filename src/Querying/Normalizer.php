<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 15:51
 */

namespace Habil\Bcoin\Querying;

use Habil\Bcoin\Meta\Helper;
use Habil\Bcoin\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;

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
     * Normalize a single of model
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     * @throws \Habil\Bcoin\Exceptions\BcoinException
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

    /**
     * Normalize a single model
     *
     * @param array $attributes
     *
     * @return \Habil\Bcoin\Model
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function normalizeModel(array $attributes)
    {
        if ($this->includeRoot()) {
            return $this->createNewModelInstance(
                $this->model->base()->singular()->camelCase(),
                $attributes[(string)$this->root()]
            );
        } else {
            $model = $this->createNewModelInstance(
                $this->model->base()->singular()->camelCase(),
                $attributes
            );

            $this->normalizeIncludeSubclasses($model, $attributes);

            return $model;
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
                        $model = $this->createNewModelInstance($root, [$this->attributeToAssign() => $entity]);
                        $this->normalizeIncludeSubclasses($model, $entity);
                        $collection[] = $model;
                    } else {
                        $model = $this->createNewModelInstance($root, $entity);
                        $this->normalizeIncludeSubclasses($model, $entity);
                        $collection[] = $model;
                    }
                }
            }
        }

        return $collection;
    }

    /**
     * Normalize when item contain directly other models in it.
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
     * Normalize when collection item contain directly the other model in it.
     *
     * @param array $attributes
     *
     * @return array|\Illuminate\Support\Collection
     */
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
     * Normalize included subclasses in model entity
     *
     * @param \Habil\Bcoin\Model $model
     * @param array              $attributes
     */
    private function normalizeIncludeSubclasses(Model $model, array $attributes)
    {
        if ($includeSubclasses = $this->includeSubclasses()) {
            foreach ($includeSubclasses as $includeSubclass) {
                if (isset($attributes[$includeSubclass])) {
                    if ($this->isCollectionAttribute($attributes[$includeSubclass])) {
                        $collection = new Collection();
                        foreach ($attributes[$includeSubclass] as $value) {
                            if ($this->isAssociativeArray($value)) {
                                $collection[] = $this->createNewModelInstance(Str::singular($includeSubclass), $value);
                            } else {
                                foreach ($value as $attributes) {
                                    $collection[] = $this->createNewModelInstance(
                                        Str::singular($includeSubclass),
                                        $attributes
                                    );
                                }
                            }
                        }
                        $model->{$includeSubclass} = $collection;
                    } else {
                        $model->{$includeSubclass} = $attributes[$includeSubclass];
                    }
                }
            }
        }
    }

    /**
     * Check to see if the entity has subclasses directly in it.
     *
     * @return bool
     */
    private function hasSubclasses()
    {
        return is_array($this->root());
    }

    /**
     * Check to see if the entity has subclasses included in it
     *
     * @return array|bool
     */
    private function includeSubclasses()
    {
        if (isset($this->options['include_subclasses'])) {
            return $this->options['include_subclasses'];
        }

        return $this->model->serializableOptions()['include_subclasses'];
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
     * Check to see if the current model should include the root
     *
     * @return bool
     */
    private function includeRoot()
    {
        return $this->model->serializableOptions()['include_root'];
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
     * Check if the attribute key is collection of attributes or is an item
     *
     * @param array $attributes
     *
     * @return bool
     */
    private function isCollectionAttribute(array $attributes)
    {
        return !(bool)count(array_filter(array_keys($attributes), 'is_string'));
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
}