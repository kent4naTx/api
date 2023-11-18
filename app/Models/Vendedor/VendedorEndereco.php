<?php

namespace App\Models\Vendedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorEndereco extends Model
{
    use HasFactory;
    protected $table = "vendedor_endereco";
    protected $guarded = [];
}
