<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required',
            'designation' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'company' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Staff name is required',
            'email.required' => 'Staff email required',
            'designation.required' => 'Staff designation is required',
            'phone.required' => 'Staff phone is required',
            'address.required' => 'Staff address is required',
            'company.required' => 'Staff company is required',
        ];
    }
}
