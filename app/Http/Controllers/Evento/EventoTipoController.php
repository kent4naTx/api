<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento\EventoTipo;
use Exception;
use Illuminate\Http\Request;

class EventoTipoController extends Controller
{
    public static function vincularTipo($evento_id, $cidade_id)
    {
        try {

            EventoTipo::create([
                "evento_id" => $evento_id,
                "tipo_evento_id" => $cidade_id
            ]);
        } catch (Exception $e) {

            return [
                "status" => false,
                "error" => $e
            ];
        }

        return [
            "status" => true,
            "error" => []
        ];
    }

}
