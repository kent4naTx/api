<?php

namespace App\Models\Loja;

use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaEndereco extends Model
{
    use HasFactory;
    protected $table = "loja_endereco";
    protected $guarded = [];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }
}
