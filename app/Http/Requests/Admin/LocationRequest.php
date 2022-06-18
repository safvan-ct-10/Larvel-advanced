<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class LocationRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $rules =  [
            'id' => 'required|max:20',
            'name' => 'required|max:255',
        ];

        return $rules;
    }

    public function messages()
    {
        return [

        ];
    }

    protected function prepareForValidation()
    {
        $data = cleanRequest($this->rules(), $this);
        $this->replace($data);
    }

    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'response' => 'error',
            'message' => implode('<br/>', $validator->errors()->all())
        ]);

        throw (new ValidationException($validator, $response))
        ->errorBag($this->errorBag)
        ->redirectTo($this->getRedirectUrl());
    }
}
