<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => ['required', 'string'],
            'category_id' => ['required', 'integer', 'exists:ref_post_category,id'],
            'thumbnail' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:10240'],
            'content' => ['required', 'string']
        ];
    }
}
