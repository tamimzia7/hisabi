<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'account_type' => ['required', 'string', Rule::in(['personal', 'mess', 'business'])],
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
            'name.required' => 'আপনার নাম লিখুন।',
            'name.max' => 'নাম খুব বড় হয়েছে।',
            'email.required' => 'ইমেইল ঠিকানা লিখুন।',
            'email.email' => 'সঠিক ইমেইল ঠিকানা লিখুন।',
            'email.unique' => 'এই ইমেইল দিয়ে আগেই নিবন্ধন করা হয়েছে।',
            'password.required' => 'পাসওয়ার্ড লিখুন।',
            'password.min' => 'পাসওয়ার্ড কমপক্ষে ৮ অক্ষরের হতে হবে।',
            'password.confirmed' => 'দুইবারের পাসওয়ার্ড মিলছে না।',
            'account_type.required' => 'একটি হিসাবের ধরন বেছে নিন।',
            'account_type.in' => 'অবৈধ হিসাবের ধরন নির্বাচিত হয়েছে।',
        ];
    }

    /**
     * Get custom attribute names in Bangla.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'name' => 'নাম',
            'email' => 'ইমেইল',
            'password' => 'পাসওয়ার্ড',
            'account_type' => 'হিসাবের ধরন',
        ];
    }
}
