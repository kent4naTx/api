<?php

namespace App\Models\Vendedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorTelefone extends Model
{
    use HasFactory;
    protected $table = "vendedor_telefone";
    protected $guarded = [];
}
