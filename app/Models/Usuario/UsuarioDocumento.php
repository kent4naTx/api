<?php

namespace App\Models\Usuario;

use App\Models\Documento\Documento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioDocumento extends Model
{
    use HasFactory;
    protected $table = "usuario_documento";
    protected $guarded = [];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
