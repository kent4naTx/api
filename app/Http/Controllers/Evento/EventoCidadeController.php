<?php

namespace App\Http\Controllers\Evento;

use App\Http\Controllers\Controller;
use App\Models\Evento\EventoCidade;
use Exception;
use Illuminate\Http\Request;

class EventoCidadeController extends Controller
{
    public static function vincularCidade($evento_id, $cidade_id):array
    {
        try {

            EventoCidade::create([
                "evento_id" => $evento_id,
                "cidade_id" => $cidade_id
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

    public static function desvincularCidade($cidade_id): array
    {
        try{
            EventoCidade::where("cidade_id", "=", $cidade_id)->findOrFail();
        }catch (Exception $e){

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
