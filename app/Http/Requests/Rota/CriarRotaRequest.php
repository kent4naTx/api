<?php

namespace App\Http\Requests\Rota;

use App\Http\Requests\Request;

class CriarRotaRequest extends Request
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
            "descricao" => "required|max:200",
            "status" => "required|numeric|exists:status_rota,id",
            "vendedor" => "numeric|exists:vendedor,id",
            "cidade" => "array",
        ];
    }

    public function messages(): array
    {
        return [
            "required" => "O campo :attribute precisa estar preenchido",
            "max" => "O campo :attribute pode ter no maxímo :max caracteres",
            "numeric" => "O campo :attribute precisa ser numerico",
            "array" => "O campo :attribute precisa ser um array",
            "exists" => "O :attribute não existe"
        ];
    }
}
