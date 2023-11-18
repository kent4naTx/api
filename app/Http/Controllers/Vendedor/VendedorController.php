<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendedor\AtualizarVendedorRequest;
use App\Http\Requests\Vendedor\CriarVendedorRequest;
use App\Models\Vendedor\Vendedor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class VendedorController extends Controller
{
    public function index(): JsonResponse
    {
        $vendedors = Vendedor::all();
        if ($vendedors->isEmpty()) {

            return parent::apiResponse(201, false, "Não existem vendedores cadastrados");
        }
        return parent::apiResponse(200, true, "Dados recuperados com sucesso", Vendedor::all());
    }

    public function show(int $id): JsonResponse
    {
        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "Vendedor não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $vendedor);
    }

    public function store(CriarVendedorRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Hash::make($request->senha);
        $dados['ativo'] = 1;

        try {
            DB::beginTransaction();
            $vendedor = Vendedor::create($dados);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Não foi possível criar vendedor", $e);
        }

        return parent::apiResponse(200, true, "Dados Criados com sucesso", $vendedor);
    }

    public function update(AtualizarVendedorRequest $request, int $id): JsonResponse
    {

        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "Vendedor não foi encontrado");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $vendedor->$key = Hash::make($value);
                } else {
                    $vendedor->$key = $value;
                }
            }
            $vendedor->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "Vendedor não pode ser atualizado", $e);
        }

        return parent::apiResponse(200, true, "Dados foram atualizados com sucesso", $vendedor);
    }

    public function destroy(int $id): JsonResponse
    {

        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "Vendedor não foi encontrado");
        }
        try {
            DB::beginTransaction();
            $vendedor->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Vendedor não pode ser deletado", $e);
        }
        return parent::apiResponse(200, true, "Vendedor foi deleteado com sucesso", $vendedor);
    }
}
