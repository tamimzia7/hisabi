<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'remember' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Get custom validation messages in simple Bangla.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'email.required' => 'ইমেইল ঠিকানা লিখুন।',
            'email.email' => 'সঠিক ইমেইল ঠিকানা লিখুন।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
        ];
    }
}
