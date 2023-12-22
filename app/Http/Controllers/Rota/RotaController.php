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

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", $rotas);
    }

    public function show(int $id): JsonResponse
    {
        $rota = Rota::find($id);
        if (is_null($rota)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", [
            "rota" => $rota,
            "cidades" => $rota->linkTo(new RotaCidade, 'rota_id', $id, "cidade"),
            "status" => $rota->linkTo(new RotaStatus, 'rota_id', $id, "sattus"),
            "vendedor" => $rota->linkTo(new RotaVendedor, 'rota_id', $id, "vendedor"),
        ]);
    }

    public function store(CriarRotaRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            /** CADASTRAR NA ROTA*/
            $rota = Rota::create([
                "nome" => $request->nome,
                "descricao" => $request->descricao,
            ]);
            /** CADASTRAR NA ROTA*/

            /** VINCULAR ROTAS COM CIDADE */
            if ($request->cidade) {
                $cidades_vinculo = RotaCidadeController::vincularRotas($rota->id, $request->cidade);
                if ($cidades_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "linkRouteCityFailed", $cidades_vinculo["error"]);
                }
            }
            /** VINCULAR ROTAS COM CIDADE */

            /** VINCULAR ROTA COM VENDEDOR */
            if ($request->vendedor) {
                $vendedor_vinculo = RotaVendedorController::vincularVendedor($rota->id, $request->vendedor);
                if ($vendedor_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "linkRouteSalesmanFailed", $vendedor_vinculo['error']);
                }
            }
            /** VINCULAR ROTA COM VENDEDOR */

            /** ADICIONAR STATUS DE ROTA */
            if ($request->status) {
                $status_vinculo = RotaStatusController::vincularStatus($rota->id, $request->status);
                if ($status_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "linkRouteStatusFailed", $status_vinculo['error']);
                }
            }
            /** ADICIONAR STATUS DE ROTA */

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", [
            "rota" => $rota,
            "cidades" => $cidades_vinculo ?? [],
            "vendedor" => $vendedor_vinculo ?? [],
            "status" => $status_vinculo ?? [],
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
                for ($i = 0; $i < sizeof($request->cidade); $i++) {
                    if ($request->cidade[$i]['action'] == "add") {
                        RotaCidadeController::vincularRotas($rota->id, [$request->cidade[$i]['cidade_id']]);
                    } else {
                        RotaCidadeController::desvincularRotas($request->cidade[$i]['cidade_id']);
                    }
                }
            }
            /** ATUALIZANDO CIDADES */

            $rota->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }
        return parent::apiResponse(200, true, "dataUpdateSuccess", $rota);
    }

    public function destroy(int $id): JsonResponse
    {

        $rota = Rota::find($id);

        if (is_null($rota)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $rota->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteFailed", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $rota);
    }
}
