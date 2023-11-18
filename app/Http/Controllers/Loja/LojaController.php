<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loja\AtualizarLojaRequest;
use App\Http\Requests\Loja\CriarLojaRequest;
use App\Models\Loja\Loja;
use Exception;
use Helpers\Senhas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class LojaController extends Controller
{
    public function index(): JsonResponse
    {
        $lojas = Loja::all();
        if ($lojas->isEmpty()) {

            return parent::apiResponse(201, false, "Não existem lojas cadastradas");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $lojas);
    }

    public function show(int $id): JsonResponse
    {
        $loja = Loja::find($id);
        if (is_null($loja)) {

            return parent::apiResponse(201, false, "Loja não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $loja);
    }

    public function store(CriarLojaRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);

        try {
            DB::beginTransaction();
            $loja = Loja::create($dados);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Não foi possível criar loja", $e);
        }

        return parent::apiResponse(200, true, "Dados Criados com sucesso", $loja);
    }

    public function update(AtualizarLojaRequest $request, int $id): JsonResponse
    {

        $loja = Loja::find($id);
        if (is_null($loja)) {

            return parent::apiResponse(201, false, "Loja não foi encontrado");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $loja->$key = Senhas::criptografar($value);
                } else {
                    $loja->$key = $value;
                }
            }
            $loja->update();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "Loja não pode ser atualizado", $e);
        }

        return parent::apiResponse(200, true, "Dados foram atualizados com sucesso", $loja);
    }

    public function destroy(int $id): JsonResponse
    {

        $loja = Loja::find($id);
        if (is_null($loja)) {

            return parent::apiResponse(201, false, "Loja não foi encontrado");
        }
        try {
            DB::beginTransaction();
            $loja->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Loja não pode ser deletado", $e);
        }

        return parent::apiResponse(200, true, "Loja foi deleteado com sucesso", $loja);
    }
}
