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
     * @throws \Habil\Bcoin\Exceptions\BcoinException
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
        return is_callable($this->options['singular']) ?
            $this->options['singular']() : $this->options['singular'];
    }

    /**
     * Return the plural name of the model
     *
     * @return string
     */
    public function plural()
    {
        return is_callable($this->options['plural']) ?
            $this->options['plural']() : $this->options['plural'];
    }
}