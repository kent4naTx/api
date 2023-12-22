<?php

namespace App\Http\Controllers\Usuario;

use App\Http\Controllers\Controller;
use App\Http\Requests\Usuario\AtualizarUsuarioRequest;
use App\Http\Requests\Usuario\CriarUsuarioRequest;
use App\Models\Documento\Documento;
use App\Models\Endereco\Endereco;
use App\Models\Telefone\Telefone;
use App\Models\Usuario\Usuario;
use App\Models\Usuario\UsuarioDocumento;
use App\Models\Usuario\UsuarioEndereco;
use App\Models\Usuario\UsuarioTelefone;
use Exception;
use Helpers\Senhas;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UsuarioController extends Controller
{
    public function index(): JsonResponse
    {
        $usuarios = Usuario::all();
        if ($usuarios->isEmpty()) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        return parent::apiResponse(200, true, "dataRetrieveSuccess", $usuarios);
    }

    public function show(int $id): JsonResponse
    {
        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        return parent::apiResponse(200, true, "dataRetrieveSuccess", [
            "profile" => $usuario,
            "documento" => $usuario->linkTo(new UsuarioDocumento, "usuario_id", $id, 'documento'),
            "telefone" => $usuario->linkTo(new UsuarioTelefone, "usuario_id", $id, 'telefone'),
            "endereco" => $usuario->linkTo(new UsuarioEndereco, "usuario_id", $id, 'endereco'),
        ]);
    }

    public function store(CriarUsuarioRequest $request): JsonResponse
    {

        $dados = $request->validated();
        $dados['senha'] = Senhas::criptografar($request->senha);

        try {
            DB::beginTransaction();

            /** CRIANDO USUARIO */
            $usuario = Usuario::create([
                "nome" => $dados['nome'],
                "email" => $dados['email'],
                "senha" => $dados['senha'],
            ]);
            /** CRIANDO USUARIO */

            /** CRIANDO DUCUMENTO */
            $documento = Documento::create([
                "tipo" => $dados['tipo_documento'],
                "numero" => $dados['numero_documento'],
            ]);
            $vincular_documento = UsuarioDocumento::create([
                "usuario_id" => $usuario->id,
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
            $vincular_endereco = UsuarioEndereco::create([
                "usuario_id" => $usuario->id,
                "endereco_id" => $endereco->id,
            ]);
            /** CRIANDO ENDERECO */

            /** CRIANDO TELEFONE */
            $telefone = Telefone::create([
                "numero" => $dados['numero_telefone'],
                "tipo" => $dados['tipo_telefone'],
                "principal" => $dados['principal'],

            ]);
            $vincular_telefone = UsuarioTelefone::create([
                "usuario_id" => $usuario->id,
                "telefone_id" => $telefone->id,
            ]);
            /** CRIANDO TELEFONE */

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataCreateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataCreateSuccess", $usuario);
    }

    public function update(AtualizarUsuarioRequest $request, int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }

        try {
            DB::beginTransaction();
            foreach ($request->validated() as $key => $value) {
                if ($key == "senha") {
                    $usuario->$key = Senhas::criptografar($value);
                } else {
                    $usuario->$key = $value;
                }
            }

            $usuario->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollback();

            return parent::apiResponse(201, false, "dataUpdateFailed", $e);
        }

        return parent::apiResponse(200, true, "dataUpdateSuccess", $usuario);
    }

    public function destroy(int $id): JsonResponse
    {

        $usuario = Usuario::find($id);
        if (is_null($usuario)) {

            return parent::apiResponse(201, false, "dataNotFound");
        }
        try {
            DB::beginTransaction();
            $usuario->delete();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            return parent::apiResponse(201, false, "dataDeleteNotFound", $e);
        }
        return parent::apiResponse(200, true, "dataDeleteSuccess", $usuario);
    }
}
