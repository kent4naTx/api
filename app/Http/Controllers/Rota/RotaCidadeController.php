<?php

namespace App\Http\Controllers\Rota;

use App\Http\Controllers\Controller;
use App\Models\Rota\RotaCidade;
use Exception;
use Illuminate\Support\Facades\DB;

class RotaCidadeController extends Controller
{
    public static function vincularRotas($rota_id, $cidades): array
    {

        try {
            DB::beginTransaction();
            foreach ($cidades as $key => $value) {
                RotaCidade::create([
                    "rota_id" => $rota_id,
                    "cidade_id" => $value
                ]);
            }
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
