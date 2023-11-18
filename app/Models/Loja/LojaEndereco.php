<?php

namespace App\Models\Loja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaEndereco extends Model
{
    use HasFactory;
    protected $table = "loja_endereco";
    protected $guarded = [];
}
