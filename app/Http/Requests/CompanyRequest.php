<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
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
            'phone' => 'required',
            'address' => 'required',
            'company_status' => 'required',
            'max_users' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Company name is required',
            'phone.required' => 'Phone is required',
            'address.required' => 'Address is required',
            'company_status.required' => 'Company status is required',
            'max_users.required' => 'Maximun users is required'
        ];
    }
}
