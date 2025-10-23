<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_name' => 'sometimes|required|string|max:255',
            'client_email' => 'sometimes|required|email|max:255',
            'client_phone' => 'sometimes|required|string|max:20',
            'project_type' => 'nullable|in:housing,commercial,office',
            'budget' => 'nullable|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'request_details' => 'sometimes|required|string|max:2000',
            'status' => 'nullable|in:pending,reviewing,quoted,accepted,rejected',
            'admin_notes' => 'nullable|string',
            'quoted_amount' => 'nullable|numeric|min:0',
        ];
    }
}
