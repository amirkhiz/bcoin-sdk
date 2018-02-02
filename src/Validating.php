<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 17:54
 */

namespace Habil\Bcoin;

use Sirius\Validation\Validator;

/**
 * Trait Validating
 *
 * @package Habil\Bcoin
 */
trait Validating
{
    /**
     * The model's validation rules
     *
     * @var array
     */
    protected $rules;

    /**
     * The validation errors
     *
     * @var array
     */
    protected $errors;

    /**
     * Formatted error messages
     *
     * @var array
     */
    protected $messages;

    /**
     * Validate sent data based on rules
     *
     * @return bool
     */
    public function validate()
    {
        $validator = new Validator;
        $validator->add($this->rules);
        if ($validator->validate($this->attributes)) {
            return TRUE;
        }

        $this->errors = $validator->getMessages();

        return FALSE;
    }

    /**
     * Return the validation errors
     *
     * @return array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * Return messages
     *
     * @return array
     */
    public function getMessages()
    {
        $this->messageFormatter();

        return $this->messages;
    }

    /**
     * Format error messages
     */
    private function messageFormatter()
    {
        foreach ($this->errors as $rule => $message) {
            foreach ($message as $item) {
                $this->messages[$rule] = (string)$item;
            }
        }
    }
}