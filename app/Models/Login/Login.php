<?php

namespace App\Models\Login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Login extends Model
{
    use HasFactory;
    protected $table = "login";
    protected $guarded = [];

    protected static function generateToken()
    {
        return bin2hex(random_bytes(24));
    }
}
