<?php

namespace App\Http\Requests\Telefone;

use App\Http\Requests\Request;
use Illuminate\Foundation\Http\FormRequest;

class AtualizarTelefoneRequest extends Request
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
            "numero_telefone" => "max:15",
            "tipo_telefone" => "",
            "principal" => "boolean"
        ];
    }

    public function messages(): array
    {
        return [
            "max" => "O campo :attribute precisa ter no maxismo :max caracteres",
            "boolean" => "O campo :attribute precisa ser boolean",
        ];
    }
}
