<?php

namespace App\Models\Telefone;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Telefone extends Model
{
    use HasFactory;
    protected $table = "telefone";
    protected $guarded = [];
}
