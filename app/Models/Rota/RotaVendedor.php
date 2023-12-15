<?php

namespace App\Models\Rota;

use App\Models\Vendedor\Vendedor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RotaVendedor extends Model
{
    use HasFactory;
    protected $table = "rota_vendedor";
    protected $guarded = [];

    public function vendedor(): BelongsTo
    {
        return $this->belongsTo(Vendedor::class, 'vendedor_id');
    }
}
