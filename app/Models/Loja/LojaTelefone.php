<?php

namespace App\Models\Loja;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaTelefone extends Model
{
    use HasFactory;
    protected $table = "loja_telefone";
    protected $guarded = [];
}
