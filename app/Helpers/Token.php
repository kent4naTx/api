<?php

namespace Helpers;

use App\Models\Login\Login;
use App\Models\Loja\Loja;
use App\Models\Usuario\Usuario;
use App\Models\Vendedor\Vendedor;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class Token
{

    public static function gerarToken(): string
    {
        return bin2hex(random_bytes(24));
    }

    public static function tokenParaId(string $token): Collection
    {
        return Login::where("token", "=", $token)->get();
    }

    public static function tokenParaUsuario(string $token): Usuario
    {
        $login = self::tokenParaId($token);
        $usuario = Usuario::where("id", "=", $login[0]->id);
        return $usuario[0];
    }
    public static function tokenParaVendedor(string $token): Vendedor
    {
        $login = self::tokenParaId($token);
        $vendedor = Vendedor::where("id", "=", $login[0]->id);
        return $vendedor[0];
    }
    public static function tokenParaLoja(string $token): Loja
    {
        $login = self::tokenParaId($token);
        $loja = Loja::where("id", "=", $login[0]->id);
        return $loja[0];
    }
}
