<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array {
        return [
            'name'        => 'required|string|max:255',
            'phone'       => 'required|string|max:255|regex:/^\+380\d{9}$/',
            'position_id' => 'required|integer',
            'email'       => 'required|string|email|max:255|unique:users',
            'photo'       => 'required|file|mimes:jpg,jpeg|max:5120',
        ];
    }
    public function messages()
    {
        return [
            'phone.regex'        => 'Invalid phone number format. Please use the format +380XXXXXXXXX.',
            'position_id.required' => 'Please select a position',
        ];
    }
}
