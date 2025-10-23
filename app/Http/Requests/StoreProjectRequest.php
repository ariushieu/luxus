<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',
            'title_vi' => 'required|string|max:255',
            'title_en' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:projects,slug',
            'description_vi' => 'nullable|string',
            'description_en' => 'nullable|string',
            'content_vi' => 'nullable|string',
            'content_en' => 'nullable|string',
            'client_name' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'area' => 'nullable|numeric|min:0',
            'year' => 'nullable|integer|min:1900|max:2100',
            'status' => 'nullable|in:completed,ongoing,planned',
            'is_featured' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ];
    }
}
