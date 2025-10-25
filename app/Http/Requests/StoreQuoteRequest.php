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
            'project_type' => 'nullable|in:housing,apartment,office,commercial',
            'project_id' => 'nullable|exists:projects,id',
            'reference_project' => 'nullable|string|max:255',
            'budget' => 'nullable|numeric|min:0|max:999999999999.99',
            'area' => 'nullable|numeric|min:0|max:999999',
            'request_details' => 'nullable|string|max:2000',
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'Vui lòng nhập họ tên',
            'client_email.required' => 'Vui lòng nhập email',
            'client_email.email' => 'Email không hợp lệ',
            'client_phone.required' => 'Vui lòng nhập số điện thoại',
            'budget.numeric' => 'Ngân sách phải là số',
            'budget.max' => 'Ngân sách không được vượt quá 999,999,999,999 VNĐ',
            'area.numeric' => 'Diện tích phải là số',
            'area.max' => 'Diện tích không được vượt quá 999,999 m²',
            'request_details.max' => 'Nội dung yêu cầu không được vượt quá 2000 ký tự',
        ];
    }
}
