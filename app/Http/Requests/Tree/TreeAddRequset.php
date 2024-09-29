<?php

namespace App\Http\Requests\Tree;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TreeAddRequset extends FormRequest
{

    protected $stopOnFirstFailure = true;

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
            'value_age' => ['nullable', 'integer', 'max:200'],
            'value_height' => ['nullable', 'integer', 'max:100'],
            'value_latitude' => ['required', 'numeric', 'max:56', 'min:40'],
            'value_longitude' => ['required', 'numeric', 'max:90', 'min:45'],
            'value_owner' => ['nullable', 'integer', 'max:30'],
            'value_spread' => ['nullable', 'integer', 'max:30'],
            'value_tree_species' => ['nullable', 'integer', 'max:150'],
            'value_trunk' => ['nullable', 'integer', 'max:300'],
            'value_vitality' => ['nullable', 'integer', 'max:30'],
            'isCropped' => ['nullable', 'boolean'],
            'isFelled' => ['nullable', 'boolean'],
            'isDangerous' => ['nullable', 'boolean'],
        ];
    }

    // public function messages() {
    //     return [
    //        "name" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "surname" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "experience" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "city" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "state" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "preparedness" => ['required' => ':attribute', 'error' => 'missing'],
    //        "contacts" => ['required' => ':attribute', 'error' => 'missing'],
    //        "photo" => ['required' => ':attribute', 'error' => 'missing'] ,
    //        "agreement" => ['required' => ':attribute', 'error' => 'missing']
    //     ];
    // }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'response' => [
                'message' => 'validation error',
                'errors' => $validator->errors()
            ]
        ]));
    }
}
