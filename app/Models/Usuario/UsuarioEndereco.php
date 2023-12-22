<?php

namespace App\Models\Usuario;

use App\Models\Endereco\Endereco;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioEndereco extends Model
{
    use HasFactory;
    protected $table = "usuario_endereco";
    protected $guarded = [];

    public function endereco()
    {
        return $this->belongsTo(Endereco::class, 'endereco_id');
    }
}
