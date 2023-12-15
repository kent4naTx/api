<?php

namespace App\Models\Rota;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class RotaStatus extends Model
{
    use HasFactory;
    protected $table = "rota_status";
    protected $guarded = [];

    public function status(): BelongsTo
    {
        return $this->belongsTo(StatusRota::class, 'status_rota_id');
    }

}
