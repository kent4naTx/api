<?php

namespace App\Models\Loja;

use App\Models\Documento\Documento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LojaDocumento extends Model
{
    use HasFactory;
    protected $table = "loja_documento";
    protected $guarded = [];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
