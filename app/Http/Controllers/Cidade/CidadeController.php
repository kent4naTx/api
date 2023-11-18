<?php

namespace App\Http\Controllers\Cidade;

use App\Http\Controllers\Controller;
use App\Http\Requests\Cidade\AtualizarCidadeRequest;
use App\Http\Requests\Cidade\CriarCidadeRequest;
use App\Models\Cidade\Cidade;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class CidadeController extends Controller
{
    public function index(): JsonResponse
    {
        $cidades = Cidade::all();
        if ($cidades->isEmpty()) {

            return parent::apiResponse(201, false, "Não existem cidades cadastradas");
        }
        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $cidades);
    }

    public function show(int $id): JsonResponse
    {
        $cidade = Cidade::find($id);
        if (is_null($cidade)) {

            return parent::apiResponse(201, false, "Cidade não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $cidade);
    }

    public function store(CriarCidadeRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $cidade = Cidade::create($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Dados não puderam ser criados", $e);
        }

        return parent::apiResponse(200, true, "Dados criados com sucesso", $cidade);
    }

    public function update(AtualizarCidadeRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $cidade = Cidade::find($id);
            foreach ($request->validated() as $key => $value) {
                $cidade->$key = $value;
            }
            $cidade->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "Atualizar dados falhou", $e);
        }
        return parent::apiResponse(200, true, "Dados foram atualizado com sucesso", $cidade);
    }

    public function destroy(int $id): JsonResponse
    {

        $cidade = Cidade::find($id);
        if (is_null($cidade)) {

            return parent::apiResponse(201, false, "Usuario não foi encontrado");
        }
        try {
            DB::beginTransaction();
            $cidade->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Usuario não pode ser deletado", $e);
        }
        return parent::apiResponse(200, true, "Usuario foi deleteado com sucesso", $cidade);
    }
}
