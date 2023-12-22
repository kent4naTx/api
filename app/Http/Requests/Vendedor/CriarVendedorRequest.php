<?php

namespace App\Http\Requests\Vendedor;

use App\Http\Requests\Request;

class CriarVendedorRequest extends Request
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
            "tipo_documento" => "required",
            "numero_documento" => "required|max:14",
            "cep" => "required|max:10",
            "bairro" => "required|max:80",
            "rua" => "required|max:80",
            "cidade" => "required|exists:cidade,id",
            "numero_endereco" => "required|max:6",
            "numero_telefone" => "required|max:15",
            "tipo_telefone" => "required",
            "principal" => "required|boolean"
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
