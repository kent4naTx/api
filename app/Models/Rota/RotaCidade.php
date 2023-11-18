<?php

namespace App\Models\Rota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotaCidade extends Model
{
    use HasFactory;
    protected $table = "rota_cidade";
    protected $guarded = [];
}
