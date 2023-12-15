<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Rota\RotaStatusController;
use App\Http\Requests\Evento\AtualizarEventoRequest;
use App\Http\Requests\Evento\CriarEventoRequest;
use App\Models\Evento\Evento;
use App\Models\Evento\EventoCidade;
use App\Models\Evento\EventoTipo;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EventoController extends Controller
{
    public function index(): JsonResponse
    {
        $eventos = Evento::all();
        if ($eventos->isEmpty()) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", $eventos);
    }

    public function show(int $id): JsonResponse
    {
        $evento = Evento::find($id);
        if (is_null($evento)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", [
            "evento" => $evento,
            "cidades" => $evento->linkTo(new EventoCidade, 'evento_id',  $id, 'cidade'),
            "tipo" => $evento->linkTo(new EventoTipo, 'evento_id', $id, 'tipo'),

        ]);
    }

    public function store(CriarEventoRequest $request): JsonResponse
    {
        try {
            DB::beginTransaction();
            /** CADASTRAR O EVENTO*/
            $evento = Evento::create([
                "nome" => $request->nome,
                "inicio" => $request->inicio,
                "fim" => $request->fim,
            ]);
            /** CADASTRAR O EVENTO*/

            /** VINCULAR EVENTO COM CIDADE */
            if ($request->cidade) {
                $cidades_vinculo = EventoCidadeController::vincularCidade($evento->id, $request->cidade);
                if ($cidades_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "linkEventCityFailed", $cidades_vinculo["error"]);
                }
            }
            /** VINCULAR EVENTO COM CIDADE */

            /** ADICIONAR TIPO DE EVENTO */
            if ($request->tipo) {
                $tipo_vinculo = EventoTipoController::vincularTipo($evento->id, $request->tipo);
                if ($tipo_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "linkEventTypeFailed", $tipo_vinculo['error']);
                }
            }
            /** ADICIONAR STATUS DE ROTA */

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", [
            "rota" => $evento,
            "cidades" => $cidades_vinculo ?? [],
            "status" => $tipo_vinculo ?? []
        ]);
    }

    public function update(AtualizarEventoRequest $request, int $id): JsonResponse
    {
        try {
            DB::beginTransaction();
            $evento = Evento::find($id);
            /** ATUALIZANDO EVENTO */
            foreach ($request->validated() as $key => $value) {
                if (in_array($key, ['nome', 'inicio', 'fim'])) {
                    $evento->$key = $value;
                }
            }
            /** ATUALIZANDO EVENTO */

            /** ATUALIZANDO CIDADES */
            if ($request->cidade) {
                if ($request->cidade['action'] == "add") {
                    EventoCidadeController::vincularCidade($evento->id, $request->cidade["cidade_id"]);
                } else {
                    EventoCidadeController::desvincularCidade($request->cidade);
                }
            }
            /** ATUALIZANDO CIDADES */

            $evento->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataUpdateSuccess", $evento);
    }

    public function destroy(int $id): JsonResponse
    {

        $evento = Evento::find($id);

        if (is_null($evento)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $evento->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteFailed", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $evento);
    }
}
