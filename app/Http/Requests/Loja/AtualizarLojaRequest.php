<?php

namespace App\Http\Requests\Loja;

use App\Http\Requests\Request;

class AtualizarLojaRequest extends Request
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
            "nome" => "max:80",
            "email" => "email|max:80|unique:loja,email",
            "senha" => "min:8",        ];
    }
    public function messages(): array
    {
        return [
            "max" => "O campo :attribute precisa ter no maxismo :max caracteres",
            "email" => "O campo :attribute precisa ser um email válido",
            "unique" => "O :attribute já existe",
            "min" => "O campo :attribute precisa ter no minimo :min caracteres",

        ];
    }
}
