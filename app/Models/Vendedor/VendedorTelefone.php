<?php

namespace App\Models\Vendedor;

use App\Models\Telefone\Telefone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorTelefone extends Model
{
    use HasFactory;
    protected $table = "vendedor_telefone";
    protected $guarded = [];

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }
}
