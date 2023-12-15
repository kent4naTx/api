<?php

namespace App\Models\Rota;

use App\Models\Cidade\Cidade;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RotaCidade extends Model
{
    use HasFactory;
    protected $table = "rota_cidade";
    protected $guarded = [];

    public function cidade(): BelongsTo
    {
        return $this->belongsTo(Cidade::class, 'cidade_id');
    }
}
