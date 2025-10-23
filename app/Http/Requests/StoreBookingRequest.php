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
            'client_name.required' => 'Name is required',
            'client_email.required' => 'Email is required',
            'client_email.email' => 'Invalid email format',
            'client_phone.required' => 'Phone number is required',
            'booking_time.required' => 'Booking time is required',
            'booking_time.after' => 'Booking time must be in the future',
        ];
    }
}
