<?php

namespace App\Http\Requests\Grinder;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGrinderRequest extends FormRequest
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
            'brand' => [
                'required',
                'string',
                'max:255',
            ],
            'name' => [
                'required',
                'string',
                'max:255',
            ],
            'image' => [
                'nullable',
                'image',
                'max:2048',
            ],
        ];
    }
} 