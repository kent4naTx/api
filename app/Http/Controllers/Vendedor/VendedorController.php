<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendedor\AtualizarVendedorRequest;
use App\Http\Requests\Vendedor\CriarVendedorRequest;
use App\Models\Vendedor\Vendedor;
use Exception;
use Helpers\Senhas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    public function index(): JsonResponse
    {
        $vendedors = Vendedor::all();
        if ($vendedors->isEmpty()) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", Vendedor::all());
    }

    public function show(int $id): JsonResponse
    {
        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $vendedor);
    }

    public function store(CriarVendedorRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);
        $dados['ativo'] = 1;

        try {
            DB::beginTransaction();
            $vendedor = Vendedor::create($dados);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", $vendedor);
    }

    public function update(AtualizarVendedorRequest $request, int $id): JsonResponse
    {

        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $vendedor->$key = Senhas::criptografar($value);
                } else {
                    $vendedor->$key = $value;
                }
            }
            $vendedor->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataUpdateSuccess", $vendedor);
    }

    public function destroy(int $id): JsonResponse
    {

        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $vendedor->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteFailed", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $vendedor);
    }
}
