<?php

namespace App\Models\Vendedor;

use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorEndereco extends Model
{
    use HasFactory;
    protected $table = "vendedor_endereco";
    protected $guarded = [];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }
}
