<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListFormulirRequest extends FormRequest
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
            'per_page' => ['nullable', 'integer'],
            'status' => ['nullable'],
            'start_date' => ['nullable', 'date', 'required_with:end_date'],
            'end_date' => ['nullable', 'date', 'after:start_date', 'required_with:start_date'],
            'is_done' => ['nullable']
        ];
    }
}
