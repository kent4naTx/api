<?php

namespace Helpers;

class Senhas
{

    public static function criptografar(string $string): string
    {
        return hash("sha256", $string);
    }
}
