<?php

namespace App\Http\Controllers\Vendedor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Vendedor\AtualizarVendedorRequest;
use App\Http\Requests\Vendedor\CriarVendedorRequest;
use App\Models\Documento\Documento;
use App\Models\Endereco\Endereco;
use App\Models\Telefone\Telefone;
use App\Models\Vendedor\Vendedor;
use App\Models\Vendedor\VendedorDocumento;
use App\Models\Vendedor\VendedorEndereco;
use App\Models\Vendedor\VendedorTelefone;
use Exception;
use Helpers\Senhas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class VendedorController extends Controller
{
    public function index(): JsonResponse
    {
        $vendedores = Vendedor::all();
        if ($vendedores->isEmpty()) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        $vendedores_fulldata = array();
        foreach ($vendedores as $vendedor) {
            array_push($vendedores_fulldata, [
                "profile" => $vendedor,
                "documento" => $vendedor->linkTo(new VendedorDocumento, "vendedor_id", $vendedor->id, "documento"),
                "telefone" => $vendedor->linkTo(new VendedorTelefone, "vendedor_id", $vendedor->id, "telefone"),
                "endereco" => $vendedor->linkTo(new VendedorEndereco, "vendedor_id", $vendedor->id, "endereco"),
            ]);
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", $vendedores_fulldata);
    }

    public function show(int $id): JsonResponse
    {
        $vendedor = Vendedor::find($id);
        if (is_null($vendedor)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", [
            "profile" => $vendedor,
            "telefone" => $vendedor->linkTo(new VendedorTelefone, "vendedor_id", $id, "telefone"),
            "endereco" => $vendedor->linkTo(new VendedorEndereco, "vendedor_id", $id, "endereco"),
            "documento" => $vendedor->linkTo(new VendedorDocumento, "vendedor_id", $id, "documento"),
        ]);
    }

    public function store(CriarVendedorRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);

        try {
            DB::beginTransaction();
            /** CRIANDO VENDEDOR */
            $vendedor = Vendedor::create([
                "nome" => $dados['nome'],
                "email" => $dados['email'],
                "senha" => $dados['senha'],
                "ativo" => 1,
            ]);
            /** CRIANDO VENDEDOR */

            /** CRIANDO DUCUMENTO */
            $documento = Documento::create([
                "tipo" => $dados['tipo_documento'],
                "numero" => $dados['numero_documento'],
            ]);

            $vincular_documento = VendedorDocumento::create([
                "vendedor_id" => $vendedor->id,
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

            $vincular_endereco = VendedorEndereco::create([
                "vendedor_id" => $vendedor->id,
                "endereco_id" => $endereco->id,
            ]);
            /** CRIANDO ENDERECO */

            /** CRIANDO TELEFONE */
            $telefone = Telefone::create([
                "numero" => $dados['numero_telefone'],
                "tipo" => $dados['tipo_telefone'],
                "principal" => $dados['principal'],

            ]);
            $vincular_telefone = VendedorTelefone::create([
                "vendedor_id" => $vendedor->id,
                "telefone_id" => $telefone->id,
            ]);
            /** CRIANDO TELEFONE */

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
