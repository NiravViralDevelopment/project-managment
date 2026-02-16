<?php

namespace App\Http\Requests\Circle;

use Illuminate\Foundation\Http\FormRequest;

class StoreCircleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'zone_id' => ['required', 'exists:zones,id'],
        ];
    }
}
