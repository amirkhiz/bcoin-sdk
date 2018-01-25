<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 23.01.2018
 * Time: 10:41
 */

namespace Habil\Bcoin\Querying;

use Habil\Bcoin\Model;

class Options
{
    /**
     * The merged array of options
     *
     * @var array
     */
    protected $options;

    /**
     * Create a new Options object
     *
     * @param \Habil\Bcoin\Model
     *
     * @throws \ReflectionException
     * @return void
     */
    public function __construct(Model $model)
    {
        $base = [
            'plural'   => $model->base()->lowercase()->plural(),
            'singular' => $model->base()->lowercase()->singular(),
        ];

        $this->options = array_merge($base, $model->getQueryableOptions());
    }

    /**
     * Return the singular name of the model
     *
     * @return string
     */
    public function singular()
    {
        return $this->options['singular']();
    }

    /**
     * Return the plural name of the model
     *
     * @return string
     */
    public function plural()
    {
        return $this->options['plural']();
    }
}