<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\EntrarRequest;
use App\Models\Login\Login;
use App\Models\Loja\Loja;
use App\Models\Usuario\Usuario;
use App\Models\Vendedor\Vendedor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
// HELPERS
use Helpers\Senhas;

class LoginController extends Controller
{
    public function entrar(EntrarRequest $request): JsonResponse
    {
        $senha = Senhas::criptografar($request->senha);
        try {
            if ($request->tipo == "usuario") {
                $loginExiste = Usuario::where("email", "=", $request->email)
                    ->where("senha", "=", $senha)
                    ->get();
            } else if ($request->tipo == "loja") {
                $loginExiste = Loja::where("email", "=", $request->email)
                    ->where("senha", "=", $senha)
                    ->get();
            } else if ($request->tipo == "vendedor") {
                $loginExiste = Vendedor::where("email", "=", $request->email)
                    ->where("senha", "=", $senha)
                    ->get();
            } else {

                return parent::apiResponse(201, false, "Tipo de usuario não reconhecido");
            }
        } catch (Exception $e) {

            return parent::apiResponse(201, false, "Erro ao testar credenciais", $e);
        }

        if ($loginExiste->isEmpty()) {

            return parent::apiResponse(201, false, "Credenciais inválidas");
        }

        try {
            DB::beginTransaction();
            $login = Login::create([
                "token" => Login::generateToken(),
                $request->tipo . "_id" => $loginExiste[0]->id
            ]);
            DB::commit();
        } catch (Exception $e) {

            return parent::apiResponse(201, false, "Login falhou", $e);
        }

        return parent::apiResponse(200, true, "Login realizado", $login);
    }

    public function sair()
    {
        
        return parent::apiResponse(200, true, "Logout realizado");
    }
}
