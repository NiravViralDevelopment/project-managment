<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user'))],
            'password' => ['sometimes', 'nullable', 'string', 'confirmed', Password::defaults()],
            'role' => ['required', 'string', Rule::exists('roles', 'name')->where('guard_name', 'web')],
            'zone_id' => ['nullable', 'integer', Rule::exists('zones', 'id')],
            'circle_id' => ['nullable', 'integer', Rule::exists('circles', 'id')],
            'division_id' => ['nullable', 'integer', Rule::exists('divisions', 'id')],
            'substation_id' => ['nullable', 'integer', Rule::exists('substations', 'id')],
        ];
    }
}
