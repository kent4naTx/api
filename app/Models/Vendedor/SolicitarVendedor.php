<?php

namespace App\Models\Vendedor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SolicitarVendedor extends Model
{
    use HasFactory;
    protected $table = "solicitar_vendedor";
    protected $guarded = [];
}
