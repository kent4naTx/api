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

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", $cidades);
    }

    public function show(int $id): JsonResponse
    {
        $cidade = Cidade::find($id);
        if (is_null($cidade)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $cidade);
    }

    public function store(CriarCidadeRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            $cidade = Cidade::create($request->validated());
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", $cidade);
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

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }
        return parent::apiResponse(200, true, "dataUpdateSuccess", $cidade);
    }

    public function destroy(int $id): JsonResponse
    {

        $cidade = Cidade::find($id);
        if (is_null($cidade)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $cidade->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteFailed", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $cidade);
    }
}
