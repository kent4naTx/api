<?php

namespace App\Models\Loja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaDocumento extends Model
{
    use HasFactory;
    protected $table = "loja_documento";
    protected $guarded = [];
}
