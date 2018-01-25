<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 16:42
 */

namespace Habil\Bcoin;

use Habil\Bcoin\Meta\Base;
use Habil\Bcoin\Querying\Configuration;

/**
 * Class Model
 *
 * @package Habil\Bcoin
 * @author  Siavash Habil <amirkhiz@gmail.com>
 */
abstract class Model
{
    use Validating, Configuration;

    /**
     * The HTTP connection
     *
     * @var \Habil\Bcoin\Connection
     */
    protected $connection;

    /**
     * The model's attributes
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The model's fillable attributes
     *
     * @var array
     */
    protected $fillable = [];

    /**
     * The model's associations
     *
     * @var array
     */
    protected $associations = [];

    /**
     * The model's related entities
     *
     * @return array
     */
    protected $relations = [];

    /**
     * The Base meta instance
     *
     * @var \Habil\Bcoin\Meta\Base
     */
    protected $base;

    /**
     * The model's queryable options
     *
     * @var array
     */
    protected $queryableOptions = [];

    /**
     * The model's serializable config
     *
     * @var array
     */
    protected $serializableConfig = [];

    /**
     * The model's persistable config
     *
     * @var array
     */
    protected $persistableConfig = [];

    /**
     * Inject the Connection dependency
     *
     * @param \Habil\Bcoin\Connection $connection
     *
     * @return void
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Get the connection instance
     *
     * @return \Habil\Bcoin\Connection $connection
     */
    public function connection()
    {
        return $this->connection;
    }

    /**
     * Return the model attributes
     *
     * @param array
     *
     * @return array
     */
    public function attributes()
    {
        return $this->attributes;
    }

    /**
     * Set attribute on object
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return void
     */
    protected function setAttribute($key, $value)
    {
        $this->attributes[$key] = $value;
    }

    /**
     * Determine if the given attribute may be mass assigned
     *
     * @param string $key
     *
     * @return bool
     */
    protected function isFillable($key)
    {
        if (in_array($key, $this->fillable)) return TRUE;
    }

    /**
     * Get the fillable attributes of a given array
     *
     * @param array $attributes
     *
     * @return array
     */
    protected function fillableFromArray(array $attributes)
    {
        if (count($this->fillable) > 0) {
            return array_intersect_key($attributes, array_flip($this->fillable));
        }

        return $attributes;
    }

    /**
     * Fill the entity with an array of attributes.
     *
     * @param array $attributes
     */
    protected function fill(array $attributes)
    {
        foreach ($this->fillableFromArray($attributes) as $key => $value) {
            if ($this->isFillable($key)) {
                $this->setAttribute($key, $value);
            }
        }
    }

    /**
     * Return the base meta class
     *
     * @return \Habil\Bcoin\Meta\Base
     * @throws \ReflectionException
     */
    public function base()
    {
        return new Base($this);
    }

    /**
     * Return the queryable options
     *
     * @return array
     */
    public function getQueryableOptions()
    {
        return $this->queryableOptions;
    }

    /**
     * Dynamically get an attribute
     *
     * @param string $key
     *
     * @return mixed
     * @throws \Exception
     */
    public function __get($key)
    {
        if (isset($this->attributes[$key])) {
            return $this->attributes[$key];
        }

        if (isset($this->relations[$key])) {
            return $this->relations[$key];
        }

        throw new \Exception("{$key} is not a valid property");
    }

    /**
     * Dynamically set an attribute.
     *
     * @param string $key
     * @param mixed  $value
     *
     * @return mixed
     * @throws \Exception
     */
    public function __set($key, $value)
    {
        if (!is_object($value) && $this->isFillable($key)) {
            $this->setAttribute($key, $value);

            return;
        }

        if (isset($this->associations[$key])) {
            $this->relations[$key] = $value;

            return;
        }

        throw new \Exception("{$key} is not a valid property");
    }
}