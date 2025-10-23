<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'value_vi' => 'nullable|string',
            'value_en' => 'nullable|string',
            'type' => 'nullable|in:text,textarea,image,url',
            'group' => 'nullable|in:general,home,about,contact',
        ];
    }
}
