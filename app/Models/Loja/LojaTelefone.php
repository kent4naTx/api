<?php

namespace App\Models\Loja;

use App\Models\Telefone\Telefone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaTelefone extends Model
{
    use HasFactory;
    protected $table = "loja_telefone";
    protected $guarded = [];

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }
}
