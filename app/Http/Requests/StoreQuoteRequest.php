<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Public endpoint
    }

    public function rules(): array
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_email' => 'required|email|max:255',
            'client_phone' => 'required|string|max:20',
            'project_type' => 'nullable|in:housing,commercial,office',
            'project_id' => 'nullable|exists:projects,id',
            'reference_project' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0',
            'area' => 'nullable|numeric|min:0',
            'request_details' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'Name is required',
            'client_email.required' => 'Email is required',
            'client_email.email' => 'Invalid email format',
            'client_phone.required' => 'Phone number is required',
            'request_details.required' => 'Request details are required',
        ];
    }
}
