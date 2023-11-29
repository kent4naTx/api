<?php

namespace App\Http\Controllers\Rota;

use App\Http\Controllers\Controller;
use App\Models\Rota\RotaStatus;
use Exception;
use Illuminate\Http\Request;

class RotaStatusController extends Controller
{
    public static function vincularStatus($rota_id, $status) :array
    {
        try {
            RotaStatus::create([
                "rota_id" => $rota_id,
                "status_rota_id" => $status
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
