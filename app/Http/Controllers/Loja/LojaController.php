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

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $lojas);
    }

    public function show(int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $loja = Loja::find($id);
            if (is_null($loja)) {

                return parent::apiResponse(201, false, "dataNotFound");
            }

            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataRetrieve");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $loja);
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

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", $loja);
    }

    public function update(AtualizarLojaRequest $request, int $id): JsonResponse
    {

        $loja = Loja::find($id);
        if (is_null($loja)) {

            return parent::apiResponse(201, false, "dataNotFound");
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

            return parent::apiResponse(201, false, "updateDataFailed", $e);
        }

        return parent::apiResponse(200, true, "updateDataSuccess", $loja);
    }

    public function destroy(int $id): JsonResponse
    {

        $loja = Loja::find($id);
        if (is_null($loja)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $loja->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteFailed", $e);
        }

        return parent::apiResponse(200, true, "dataDeleteSuccess", $loja);
    }
}
