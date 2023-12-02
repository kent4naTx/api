<?php

namespace App\Http\Requests\Evento;

use App\Http\Requests\Request;

class CriarEventoRequest extends Request
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
            "inicio" => "date",
            "fim" => "date",
            "cidade" => "exists:cidade,id",
            "tipo" => "exists:tipo_evento,id"
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "O :attribute é requirido",
            "date" => "O :attribute precisa ser uma data válida",
            "exists" => "O :attribute não existe"
        ];
    }
}
