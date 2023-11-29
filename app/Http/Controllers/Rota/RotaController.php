<?php

namespace App\Http\Controllers\Rota;

use App\Http\Controllers\Controller;
use App\Http\Requests\Rota\AtualizarRotaRequest;
use App\Http\Requests\Rota\CriarRotaRequest;
use App\Models\Rota\Rota;
use App\Models\Rota\RotaCidade;
use App\Models\Rota\RotaStatus;
use App\Models\Rota\RotaVendedor;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class RotaController extends Controller
{
    public function index(): JsonResponse
    {
        $rotas = Rota::all();
        if ($rotas->isEmpty()) {

            return parent::apiResponse(201, false, "Não existem rotas cadastradas");
        }
        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $rotas);
    }

    public function show(int $id): JsonResponse
    {
        $rota = Rota::find($id);
        if (is_null($rota)) {

            return parent::apiResponse(201, false, "Rota não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $rota);
    }

    public function store(CriarRotaRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            /** CADASTRAR NA ROTA*/
            $rota = Rota::create([
                "nome" => $request->nome,
                "descricao" => $request->descricao
            ]);
            /** CADASTRAR NA ROTA*/

            /** VINCULAR ROTAS COM CIDADE */
            if ($request->cidade) {
                $cidades_vinculo = RotaCidadeController::vincularRotas($rota->id, $request->cidade);
                if ($cidades_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "Não foi possível vincular rotas", $cidades_vinculo["error"]);
                }
            }
            /** VINCULAR ROTAS COM CIDADE */

            /** VINCULAR ROTA COM VENDEDOR */
            if ($request->vendedor) {
                $vendedor_vinculo = RotaVendedorController::vincularVendedor($rota->id, $request->vendedor);
                if ($vendedor_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "Não foi possível vincular vendedor", $vendedor_vinculo['error']);
                }
            }
            /** VINCULAR ROTA COM VENDEDOR */

            /** ADICIONAR STATUS DE ROTA */
            if ($request->status) {
                $status_vinculo = RotaStatusController::vincularStatus($rota->id, $request->status);
                if ($status_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "Não foi possível vincular status com rota", $status_vinculo['error']);
                }
            }
            /** ADICIONAR STATUS DE ROTA */

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Dados não puderam ser criados", $e);
        }

        return parent::apiResponse(200, true, "Dados criados com sucesso", [
            "rota" => $rota,
            "cidades" => $cidades_vinculo ?? [],
            "vendedor" => $vendedor_vinculo ?? [],
            "status" => $status_vinculo ?? []
        ]);
    }

    public function update(AtualizarRotaRequest $request, int $id): JsonResponse
    {

        try {
            DB::beginTransaction();
            $rota = Rota::find($id);
            /** ATUALIZANDO ROTA */
            foreach ($request->validated() as $key => $value) {
                if (in_array($key, ['nome', 'descricao'])) {
                    $rota->$key = $value;
                }
            }
            /** ATUALIZANDO ROTA */

            /** ATUALIZANDO STATUS DA ROTA */
            if ($request->status) {
                $status = RotaStatus::where('rota_id', '=', $rota->id)->firstOrFail();
                $status->status_rota_id = $request->status;
                $status->save();
            }
            /** ATUALIZANDO STATUS DA ROTA */

            /** ATUALIZANDO VENDEDOR DA ROTA */
            if ($request->vendedor) {
                $vendedor = RotaVendedor::where('rota_vendedor', '=', $rota->id)->firstOrFail();
                $vendedor->vendedor_id = $request->vendedor;
                $vendedor->save();
            }
            /** ATUALIZANDO VENDEDOR DA ROTA */

            /** ATUALIZANDO CIDADES */
            if ($request->cidade) {
            }
            /** ATUALIZANDO CIDADES */


            $rota->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "Atualizar dados falhou", $e);
        }
        return parent::apiResponse(200, true, "Dados foram atualizado com sucesso", $rota);
    }

    public function destroy(int $id): JsonResponse
    {

        $rota = Rota::find($id);

        if (is_null($rota)) {

            return parent::apiResponse(201, false, "Dados não foram encontrados");
        }
        try {
            DB::beginTransaction();
            $rota->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Dados não puderam ser deletados", $e);
        }
        return parent::apiResponse(200, true, "Dados foram deletados com sucesso", $rota);
    }
}
