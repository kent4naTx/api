<?php

namespace App\Http\Requests\Evento;

use App\Http\Requests\Request;

class AtualizarEventoRequest extends Request
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
            "inicio" => "date",
            "fim" => "date",
            "cidade" => "array",
        ];
    }

    public function messages(): array
    {
        return [
            "date" => "O :attribute precisa ser uma data válida",
            "array" => "O :attribute não existe"
        ];
    }
}
