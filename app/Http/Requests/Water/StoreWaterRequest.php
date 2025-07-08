<?php

namespace App\Http\Requests\Water;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreWaterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'chlorine' => ['nullable', 'numeric'],
            'calcium' => ['required', 'numeric'],
            'magnesium' => ['required', 'numeric'],
            'total_dissolved_solids' => ['nullable', 'numeric'],
            'bicarbonate' => ['required', 'numeric'],
            'ph' => ['nullable', 'numeric'],
            'sodium' => ['nullable', 'numeric'],
        ];
    }
} 