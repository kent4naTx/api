<?php

namespace App\Http\Controllers\Rota;

use App\Http\Controllers\Controller;
use App\Models\Rota\RotaVendedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RotaVendedorController extends Controller
{
    public static function vincularVendedor($rota_id, $vendedor): array
    {
        try {
            DB::beginTransaction();
            RotaVendedor::create([
                "rota_id" => $rota_id,
                "vendedor_id" => $vendedor,
            ]);
            DB::commit();
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
