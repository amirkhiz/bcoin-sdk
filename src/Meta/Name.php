<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 17:30
 */

namespace Habil\Bcoin\Meta;

use Illuminate\Support\Pluralizer;
use Illuminate\Support\Str;

class Name
{
    /**
     * The name
     *
     * @var string
     */
    protected $name;

    /**
     * Create a new Name instance
     *
     * @param string $name
     *
     * @return void
     */
    public function __construct($name)
    {
        $this->name = $name;
    }

    /**
     * Convert the name to lowercase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function lowercase()
    {
        return new Name(strtolower($this->name));
    }

    /**
     * Convert the name to uppercase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function uppercase()
    {
        return new Name(strtoupper($this->name));
    }

    /**
     * Convert the name to plural
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function plural()
    {
        return new Name(Pluralizer::plural($this->name));
    }

    /**
     * Convert the name to singular
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function singular()
    {
        return new Name(Pluralizer::singular($this->name));
    }

    /**
     * Convert the name to camelcase
     *
     * @return \Habil\Bcoin\Meta\Name
     */
    public function camelcase()
    {
        return new Name(Str::camel($this->name));
    }

    /**
     * Return the name as a string
     *
     * @return string
     */
    public function __toString()
    {
        return $this->name;
    }
}