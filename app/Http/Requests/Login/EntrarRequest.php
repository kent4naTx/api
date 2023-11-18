<?php

namespace App\Http\Requests\Login;

use App\Http\Requests\Request;

class EntrarRequest extends Request
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
            "email" => "required|email|max:80",
            "senha" => "required|min:8",
            "tipo" => "required|in:usuario,vendedor,loja"
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "O campo :attribute precisa estar preenchido",
            "email" => "O campo :attribute um email valido",
            "max" => "O campo :attribute pode ter no maximo :max caracteres",
            "min" => "O campo :attribute pode ter no minimo :min caracteres",
            "in" => "O campo :attribute precisar estar entre :in"
        ];
    }
}
