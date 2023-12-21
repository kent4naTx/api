<?php

namespace App\Models\Vendedor;

use App\Models\LinkedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vendedor extends LinkedModel
{
    use HasFactory;
    protected $table = "vendedor";
    protected $guarded = [];
}
