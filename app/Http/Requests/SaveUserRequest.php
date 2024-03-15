<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveUserRequest extends FormRequest
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
            'dni' => ['required'],
            'nombres' => ['required', 'max:50'],
            'apellidos' => ['required', 'max:50'],
            'email' => ['required', 'max:255'],
            'password' => ['required', 'max:255', 'confirmed'],
        ];
    }
}
