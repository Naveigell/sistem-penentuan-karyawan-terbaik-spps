<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EmployeeRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"     => "required|string|max:255",
            "username" => "required|string|max:255",
            "email"    => "required|string|email|max:255",
            "phone"    => "required|string|max:255",
            "address"  => "required|string|max:255",
        ];
    }

    /**
     * Return the validated phone and address.
     *
     * @return array{phone: string, address: string}
     */
    public function employeeData()
    {
        return $this->only(['phone', 'address']);
    }

    /**
     * Return the validated name, username and email.
     *
     * @return array{name: string, username: string, email: string}
     */
    public function userData()
    {
        return array_merge($this->only(['name', 'username', 'email']), [
            'password' => 123456, // should be change later
        ]);
    }
}
