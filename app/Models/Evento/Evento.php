<?php

namespace App\Models\Evento;

use App\Models\LinkedModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evento extends LinkedModel
{
    use HasFactory;
    protected $table = "evento";
    protected $guarded = [];
}
