<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

abstract class CustomFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw (new ValidationException($validator))
            ->status(400)
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
