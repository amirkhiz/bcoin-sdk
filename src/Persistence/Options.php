<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 24.01.2018
 * Time: 12:24
 */

namespace Habil\Bcoin\Persistence;

use Habil\Bcoin\Model;

class Options
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
     * Options constructor.
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
     * Generate the create endpoint
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function create()
    {
        if (isset($this->options['create'])) return $this->options['create']();

        return $this->model->base()->lowercase()->plural();
    }

    /**
     * Generate the update endpoint
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function update()
    {
        if (isset($this->options['update'])) return $this->options['update']();

        return $this->model->base()->lowercase()->singular() . '/' . $this->model->id;
    }

    /**
     * Generate the delete endpoint
     *
     * @return string
     * @throws \Habil\Bcoin\Exceptions\BcoinException
     */
    public function delete()
    {
        if (isset($this->options['delete'])) return $this->options['delete']();

        return $this->model->base()->lowercase()->singular() . '/' . $this->model->id;
    }
}