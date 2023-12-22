<?php

namespace App\Models\Usuario;

use App\Models\Telefone\Telefone;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioTelefone extends Model
{
    use HasFactory;
    protected $table = "usuario_telefone";
    protected $guarded = [];

    public function telefone()
    {
        return $this->belongsTo(Telefone::class, 'telefone_id');
    }
}
