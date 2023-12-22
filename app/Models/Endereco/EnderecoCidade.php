<?php

namespace App\Models\Endereco;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EnderecoCidade extends Model
{
    use HasFactory;

    protected $table = "endereco_cidade";
    protected $guarded = [];
}
