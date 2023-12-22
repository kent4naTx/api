<?php

namespace App\Models\Loja;

use App\Models\LinkedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Loja extends LinkedModel
{
    use HasFactory;
    protected $table = "loja";
    protected $guarded = [];
}
