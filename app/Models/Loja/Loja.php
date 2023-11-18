<?php

namespace App\Models\Loja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loja extends Model
{
    use HasFactory;
    protected $table = "loja";
    protected $guarded = [];
}
