<?php

namespace App\Models\Vendedor;

use App\Models\Documento\Documento;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendedorDocumento extends Model
{
    use HasFactory;
    protected $table = "vendedor_documento";
    protected $guarded = [];

    public function documento()
    {
        return $this->belongsTo(Documento::class, 'documento_id');
    }
}
