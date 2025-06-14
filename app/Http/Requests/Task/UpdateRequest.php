<?php

declare(strict_types=1);

namespace App\Http\Requests\Task;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:191'],
            'description' => ['nullable', 'string', 'max:500'],
            'due_date' => ['nullable', 'date', 'after:tomorrow'],
            'priority' => ['required', 'string', Rule::enum(TaskPriorityEnum::class)],
            'status' => ['required', 'string', Rule::enum(TaskStatusEnum::class)],
            'category_id' => ['required', 'exists:categories,id'],
            'subcategory_id' => ['nullable', 'exists:categories,id'],
        ];
    }
}
