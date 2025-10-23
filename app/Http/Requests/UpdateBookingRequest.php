<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBookingRequest extends FormRequest
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
            'booking_time' => 'sometimes|required|date',
            'message' => 'nullable|string|max:1000',
            'status' => 'nullable|in:pending,confirmed,completed,cancelled',
            'admin_notes' => 'nullable|string',
        ];
    }
}
