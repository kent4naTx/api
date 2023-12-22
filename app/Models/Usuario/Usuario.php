<?php

namespace App\Models\Usuario;

use App\Models\LinkedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends LinkedModel
{
    use HasFactory;
    protected $table = "usuario";
    protected $guarded = [];
}
