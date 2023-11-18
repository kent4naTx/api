<?php

namespace App\Http\Requests\Cidade;

use App\Http\Requests\Request;

class CriarCidadeRequest extends Request
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
            "estado_id" => "required|exists:estado,id",
            "latitude" => "required",
            "longitude" => "required",
            "nome" => "required|max:80"
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "O campo :attribute precisa estar preenchido",
            "exists" => "O campo :attribute precisa ser um estado existente",
            "decimal" => "O campo :attribute não é válido",
            "max" => "O campo :attribute pode ter no maxímo :max caracteres"
        ];
    }
}
