<?php

namespace App\Http\Requests\Rota;

use App\Http\Requests\Request;

class AtualizarRotaRequest extends Request
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
            "descricao" => "max:200",
            "status" => "numeric|exists:status_rota,id",
            "vendedor" => "exists:vendedor,id",
            "cidade" => "array",
        ];
    }

    public function messages(): array
    {
        return [
            "max" => "O campo :attribute pode ter no maxímo :max caracteres",
            "numeric" => "O campo :attribute precisa ser numerico",
            "array" => "O campo :attribute precisa ser um array",
            "exists" => "O :attribute não existe"
        ];
    }
}
