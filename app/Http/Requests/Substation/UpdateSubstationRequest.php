<?php

namespace App\Http\Requests\Substation;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSubstationRequest extends FormRequest
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
            'circle_id' => ['required', 'exists:circles,id'],
            'division_id' => ['required', 'exists:divisions,id'],
        ];
    }
}
