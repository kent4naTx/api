<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LinkedModel extends Model
{
    use HasFactory;

    /** FUNÇÂO ADICIONADA */
    public function linkTo(Model $model, $id, $callback)
    {
        $response = array();
        $items = $model::where('rota_id', $id)->get();
        foreach ($items as $item) {
            array_push($response, $item->$callback);
        }

        return $response;
    }
    /** FUNÇÂO ADICIONADA */
}
