<?php

namespace App\Models\Login;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoLogin extends Model
{
    use HasFactory;
    protected $table = "historico_login";
    protected $guarded = [];
}
