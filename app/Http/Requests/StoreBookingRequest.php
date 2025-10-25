<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
            'booking_time' => 'required|date|after:now',
            'message' => 'nullable|string|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'client_name.required' => 'Vui lòng nhập họ tên',
            'client_email.required' => 'Vui lòng nhập email',
            'client_email.email' => 'Email không hợp lệ',
            'client_phone.required' => 'Vui lòng nhập số điện thoại',
            'booking_time.required' => 'Vui lòng chọn thời gian đặt lịch',
            'booking_time.after' => 'Thời gian đặt lịch phải sau thời điểm hiện tại',
            'message.max' => 'Lời nhắn không được vượt quá 1000 ký tự',
        ];
    }
}
