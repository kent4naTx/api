<?php

namespace Helpers;

use App\Models\Login\Login;

class Token
{

    public static function gerarToken(): string
    {
        return bin2hex(random_bytes(24));
    }

    public static function tokenParaId(string $token)
    {
        return Login::where("token", "=", $token)->get();
    }
}
