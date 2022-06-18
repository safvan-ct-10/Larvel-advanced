<?php

namespace App\Http\Requests\Admin;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserRequest extends FormRequest
{
    public function authorize()
    {
        return Auth::check();
    }

    public function rules()
    {
        $rules =  [
            'id' => 'required|max:20',
            'name' => 'required','max:255',
            'email' => 'required|email|unique:users,email,'.$this->id,
            'password' => 'required_if:id,0',
            'dob' => 'required|date_format:Y-m-d'
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'password.required_if' => 'The password field is required.'
        ];
    }

    protected function prepareForValidation()
    {
        $data = cleanRequest($this->rules(), $this);
        $this->replace($data);
    }
}
