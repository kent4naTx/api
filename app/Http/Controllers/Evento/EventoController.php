<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Rota\RotaStatusController;
use App\Http\Requests\Evento\AtualizarEventoRequest;
use App\Http\Requests\Evento\CriarEventoRequest;
use App\Models\Evento\Evento;
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

            return parent::apiResponse(201, false, "Não existem eventos cadastradas");
        }
        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $eventos);
    }

    public function show(int $id): JsonResponse
    {
        $evento = Evento::find($id);
        if (is_null($evento)) {

            return parent::apiResponse(201, false, "Evento não existe");
        }

        return parent::apiResponse(200, true, "Dados recuperados com sucesso", $evento);
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

                    return parent::apiResponse(201, false, "Não foi possível vincular evento com cidade", $cidades_vinculo["error"]);
                }
            }
            /** VINCULAR EVENTO COM CIDADE */

            /** ADICIONAR TIPO DE EVENTO */
            if ($request->tipo) {
                $tipo_vinculo = EventoTipoController::vincularTipo($evento->id, $request->tipo);
                if ($tipo_vinculo['status'] == false) {

                    return parent::apiResponse(201, false, "Não foi possível vincular status com rota", $tipo_vinculo['error']);
                }
            }
            /** ADICIONAR STATUS DE ROTA */

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Dados não puderam ser criados", $e);
        }

        return parent::apiResponse(200, true, "Dados criados com sucesso", [
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

            return parent::apiResponse(201, false, "Atualizar dados falhou", $e);
        }

        return parent::apiResponse(200, true, "Dados foram atualizado com sucesso", $evento);
    }

    public function destroy(int $id): JsonResponse
    {

        $evento = Evento::find($id);

        if (is_null($evento)) {

            return parent::apiResponse(201, false, "Dados não foram encontrados");
        }
        try {
            DB::beginTransaction();
            $evento->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "Dados não puderam ser deletados", $e);
        }
        return parent::apiResponse(200, true, "Dados foram deletados com sucesso", $evento);
    }
}
