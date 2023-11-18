<?php

namespace App\Models\Documento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documento extends Model
{
    use HasFactory;
    protected $table = "documento";
    protected $guarded = [];
}
