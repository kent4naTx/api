<?php

namespace App\Models\Evento;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoTipo extends Model
{
    use HasFactory;
    protected $table = "evento_tipo";
    protected $guarded = [];

    public function tipo()
    {
        return $this->belongsTo(TipoEvento::class, "tipo_evento_id");
    }
}
