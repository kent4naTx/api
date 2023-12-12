<?php

namespace App\Http\Controllers\Login;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login\EntrarRequest;
use App\Models\Login\Login;
use App\Models\Loja\Loja;
use App\Models\Usuario\Usuario;
use App\Models\Vendedor\Vendedor;
use Exception;
use Helpers\Senhas;
use Helpers\Token;
use Illuminate\Http\JsonResponse;
// HELPERS
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

                return parent::apiResponse(201, false, "userTypeError");
            }
        } catch (Exception $e) {

            return parent::apiResponse(201, false, "credentialsError", $e);
        }

        if ($loginExiste->isEmpty()) {

            return parent::apiResponse(201, false, "credentialsInvalid");
        }

        try {
            DB::beginTransaction();
            $login = Login::create([
                "token" => Token::gerarToken(),
                $request->tipo . "_id" => $loginExiste[0]->id,
            ]);
            DB::commit();
        } catch (Exception $e) {

            return parent::apiResponse(201, false, "loginFailed", $e);
        }

        return parent::apiResponse(200, true, "loginSuccess", $login);
    }

    public function sair(Request $request): JsonResponse
    {
        $login = Token::tokenParaId($request->header("Authorization"));

        if ($login->isEmpty()) {

            return parent::apiResponse(201, false, "userNotLogged");
        }
        try {
            DB::beginTransaction();
            $login[0]->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "logoutFailed", $e);
        }

        return parent::apiResponse(200, true, "logoutSuccess");
    }
}
