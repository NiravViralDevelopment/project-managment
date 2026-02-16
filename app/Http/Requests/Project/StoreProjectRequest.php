<?php

namespace App\Http\Requests\Project;

use App\Enums\ProjectStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProjectRequest extends FormRequest
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
            'description' => ['nullable', 'string', 'max:5000'],
            'status' => ['required', 'string', Rule::in(ProjectStatus::values())],
            'deadline' => ['nullable', 'date'],
            'substation_id' => ['nullable', 'integer', 'exists:substations,id'],
            'timeline' => ['nullable', 'string', 'max:255'],
            'date_of_commissioning' => ['nullable', 'date'],
            'scheduled_date_of_completion' => ['nullable', 'date'],
            'project_cost' => ['nullable', 'numeric', 'min:0'],
            'scheme' => ['nullable', 'string', 'max:255'],
            'project_manager_id' => ['nullable', 'integer', 'exists:users,id'],
            'members' => ['nullable', 'array'],
            'members.*' => ['integer', 'exists:users,id'],
        ];
    }
}
