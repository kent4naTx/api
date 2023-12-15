<?php

namespace App\Models\Evento;

use App\Models\Cidade\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoCidade extends Model
{
    use HasFactory;

    protected $table = "evento_cidade";
    protected $guarded = [];

    public function cidade(){
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }
}
