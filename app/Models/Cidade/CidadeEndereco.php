<?php

namespace App\Models\Cidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CidadeEndereco extends Model
{
    use HasFactory;

    protected $table = "cidade_endereco";
    protected $guarded = [];
}
