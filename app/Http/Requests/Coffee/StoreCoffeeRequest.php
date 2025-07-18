<?php

namespace App\Http\Requests\Coffee;

use Illuminate\Foundation\Http\FormRequest;

class StoreCoffeeRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255'
            ],
            'description' => [
                'nullable',
                'string'
            ],
            'sensory' => [
                'nullable',
                'string'
            ],
            'farm' => [
                'nullable',
                'string'
            ],
            'variety' => [
                'nullable',
                'string'
            ],
            'region' => [
                'nullable',
                'string'
            ],
            'altitude' => [
                'nullable',
                'integer'
            ],
            'producer' => [
                'nullable',
                'string'
            ],
            'processing_method' => [
                'nullable',
                'string'
            ],
            'roaster' => [
                'nullable',
                'string'
            ],
            'brand_id' => [
                'required',
                'exists:brands,id'
            ],
            'image' => [
                'nullable',
                'image',
                'max:2048' // 2MB
            ],
            'roast_level_id' => [
                'required',
                'exists:roast_levels,id'
            ],
        ];
    }
}
