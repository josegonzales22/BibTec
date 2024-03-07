<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveLibroRequest extends FormRequest
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
            'titulo' => ['required', 'max:100'],
            'editorial' => ['required', 'max:100'],
            'pub' => ['required', 'numeric'],
            'genero' => ['required', 'max:50'],
            'numpag' => ['required', 'numeric'],
            'idioma' => ['required', 'max:50'],
            'cantidad' => ['required', 'numeric']
        ];
    }
}
