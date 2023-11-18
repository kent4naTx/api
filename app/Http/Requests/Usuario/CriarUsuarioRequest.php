<?php

namespace App\Http\Requests\Usuario;

use App\Http\Requests\Request;


class CriarUsuarioRequest extends Request
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
            "nome" => "required|max:80",
            "email" => "required|email|max:80|unique:usuario,email",
            "senha" => "required|min:8",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "O campo :attribute precisa estar preenchido",
            "max" => "O campo :attribute precisa ter no maxismo :max caracteres",
            "email" => "O campo :attribute precisa ser um email válido",
            "unique" => "O :attribute já existe",
            "min" => "O campo :attribute precisa ter no minimo :min caracteres",

        ];
    }
}
