<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 14:22
 */

namespace Habil\Bcoin;

/**
 * Trait Serializable
 *
 * @property array $serializableConfig
 * @package Habil\Bcoin
 */
trait Serializable
{
    /**
     * An array of serializable options
     *
     * @var array
     */
    protected $serializableOptions;

    /**
     * Serialize the current object to JSON
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function toJson()
    {
        return $this->serializer()->serialize($this);
    }

    /**
     * Return the serializable options
     *
     * @return array
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function serializableOptions()
    {
        $this->setSerializableOptionsArray();

        return array_merge($this->serializableOptions, $this->serializableConfig);
    }

    /**
     * Set the serializable options array
     *
     * @return void
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function setSerializableOptionsArray()
    {
        $this->serializableOptions = [
            'root'               => $this->base()->lowercase()->singular(),
            'collection_root'    => $this->base()->lowercase()->plural(),
            'include_root'       => TRUE,
            'additional_methods' => [],
        ];
    }

    /**
     * Create a new Serializer object
     *
     * @return Serializer
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    private function serializer()
    {
        $this->setSerializableOptionsArray();

        return new Serializer($this->serializableOptions());
    }
}