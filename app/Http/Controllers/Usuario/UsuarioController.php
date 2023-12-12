<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\CriarUsuarioRequest;
use App\Http\Requests\Usuario\AtualizarUsuarioRequest;
use App\Models\Usuario\Usuario;
use Exception;
use Helpers\Senhas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::all();
        if($usuarios->isEmpty()){

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", $usuarios);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $usuario);
    }

    public function store(CriarUsuarioRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);

        try {
            DB::beginTransaction();
            $usuario = Usuario::create($dados);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", $usuario);
    }

    public function update(AtualizarUsuarioRequest $request, int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $usuario->$key = Senhas::criptografar($value);
                } else {
                    $usuario->$key = $value;
                }
            }
            $usuario->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataUpdateSuccess", $usuario);
    }

    public function destroy(int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $usuario->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteNotFound", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $usuario);
    }
}
