<?php

namespace App\Http\Controllers\Loja;

use App\Http\Controllers\Controller;
use App\Http\Requests\Loja\AtualizarLojaRequest;
use App\Http\Requests\Loja\CriarLojaRequest;
use App\Models\Documento\Documento;
use App\Models\Endereco\Endereco;
use App\Models\Loja\Loja;
use App\Models\Loja\LojaDocumento;
use App\Models\Loja\LojaEndereco;
use App\Models\Loja\LojaTelefone;
use App\Models\Telefone\Telefone;
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

        return parent::apiResponse(200, true, "dataRetrieveSuccess", [
            "profile" => $loja,
            "documento" => $loja->linkTo(new LojaDocumento, 'loja_id', $id, 'documento'),
            "telefone" => $loja->linkTo(new LojaTelefone, 'loja_id', $id, 'telefone'),
            "endereco" => $loja->linkTo(new LojaEndereco, 'loja_id', $id, 'endereco'),
        ]);
    }

    public function store(CriarLojaRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);

        try {
            DB::beginTransaction();
            /** CRIANDO LOJA */
            $loja = Loja::create([
                "nome" => $dados['nome'],
                "email" => $dados['email'],
                "senha" => $dados['senha'],
            ]);
            /** CRIANDO LOJA */

            /** CRIANDO DUCUMENTO */
            $documento = Documento::create([
                "tipo" => $dados['tipo_documento'],
                "numero" => $dados['numero_documento'],
            ]);
            $vincular_documento = LojaDocumento::create([
                "loja_id" => $loja->id,
                "documento_id" => $documento->id,
            ]);
            /** CRIANDO DUCUMENTO */

            /** CRIANDO ENDERECO */
            $endereco = Endereco::create([
                "cep" => $dados['cep'],
                "bairro" => $dados['bairro'],
                "rua" => $dados['rua'],
                "numero" => $dados['numero_endereco'],
                "cidade_id" => $dados['cidade'],
            ]);
            $vincular_endereco = LojaEndereco::create([
                "loja_id" => $loja->id,
                "endereco_id" => $endereco->id,
            ]);
            /** CRIANDO ENDERECO */

            /** CRIANDO TELEFONE */
            $telefone = Telefone::create([
                "numero" => $dados['numero_telefone'],
                "tipo" => $dados['tipo_telefone'],
                "principal" => $dados['principal'],

            ]);
            $vincular_telefone = LojaTelefone::create([
                "loja_id" => $loja->id,
                "telefone_id" => $telefone->id,
            ]);
            /** CRIANDO TELEFONE */

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
            $loja->save();
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
