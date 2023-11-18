<?php

namespace App\Models\Cidade;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cidade extends Model
{
    use HasFactory;
    protected $table = "cidade";
    protected $guarded = [];
}
