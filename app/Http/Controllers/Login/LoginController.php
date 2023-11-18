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
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function entrar(EntrarRequest $request)
    {
        $senha = Hash::make($request->senha);

        try {
            if ($request->tipo == 1) {
                $loginExiste = Usuario::where("email", "=", $request->email)
                    // ->where("senha", "=", $senha)
                    ->get();
            } else if ($request->tipo == 2) {
                $loginExiste = Loja::where("email", "=", $request->email)
                    ->where("senha", "=", $senha)
                    ->get();
            } else if ($request->tipo == 3) {
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

            return parent::apiResponse(201, false, "Credenciais inválidas", $request->validated());
        }
        return $loginExiste;
        try {
            DB::beginTransaction();
            $login = Login::create([
                "token" => Login::generateToken(),
                $loginExiste
            ]);
            DB::commit();
        } catch (Exception $e) {

            return parent::apiResponse(201, false, "Login falhou", $e);
        }

        return parent::apiResponse(200, true, "Login realizado", $login);
    }

    public function sair()
    {
    }
}
