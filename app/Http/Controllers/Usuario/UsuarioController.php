<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\CriarUsuarioRequest;
use App\Http\Requests\Usuario\AtualizarUsuarioRequest;
use App\Models\Usuario\Usuario;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        return parent::apiResponse(200, true, "Dados recuperados com sucesso", Usuario::all());
    }

    public function show(int $id): JsonResponse
    {
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "Usuario não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $usuario);
    }

    public function store(CriarUsuarioRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Hash::make($request->senha);

        try {
            DB::beginTransaction();
            $usuario = Usuario::create($dados);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Não foi possível criar usuario", $e);
        }

        return parent::apiResponse(200, true, "Dados Criados com sucesso", $usuario);
    }

    public function update(AtualizarUsuarioRequest $request, int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "Usuario não foi encontrado");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $usuario->$key = Hash::make($value);
                } else {
                    $usuario->$key = $value;
                }
            }
            $usuario->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "Usuario não pode ser atualizado", $e);
        }

        return parent::apiResponse(200, true, "Dados foram atualizados com sucesso", $usuario);
    }

    public function destroy(int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "Usuario não foi encontrado");
        }
        try {
            DB::beginTransaction();
            $usuario->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Usuario não pode ser deletado", $e);
        }
        return parent::apiResponse(200, true, "Usuario foi deleteado com sucesso", $usuario);
    }
}