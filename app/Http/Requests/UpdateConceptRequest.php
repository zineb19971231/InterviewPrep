<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateConceptRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'explanation' => ['required', 'string'],
            'difficulty' => ['required', Rule::in(['junior', 'mid', 'senior'])],
            'status' => ['required', Rule::in(['to_review', 'in_progress', 'mastered'])],
        ];
    }
}
