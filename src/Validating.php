<?php
/**
 * Created by PhpStorm.
 * User: habil.crypto
 * Date: 22.01.2018
 * Time: 17:54
 */

namespace Habil\Bcoin;

use Sirius\Validation\Validator;

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
}