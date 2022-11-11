<?php

namespace App\Http\Requests;

use App\Exceptions\MyValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class LeavesR extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        throw new MyValidationException($validator, 'validation');
    }

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'leave_type' => ['required', 'integer'],
            'leave_count' => ['required', 'integer'],            
        ];
    }

    public function messages()
    {
        return [
            'required' => ':attribute required',
            'min' => ':attribute must be at least :min characters',
            'max' => ':attribute must less than :max characters',
            'string' => ':attribute must only use characters',
            'email' => ':attribute must a valid email',
            'url' => ':attribute must a valid url',
            'mimes' => ':attribute must be only a jpg or png',
            'integer' => ':attribute must be an integer',
        ];
    }

    public function attributes()
    {
        return [];
    }
}
