<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Cidade\CidadeController;
use App\Http\Controllers\Evento\EventoController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Loja\LojaController;
use App\Http\Controllers\Rota\RotaController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Vendedor\VendedorController;
use App\Http\Middleware\ValidateToken;
use Illuminate\Support\Facades\Route;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

/** LOGIN */
Route::post("entrar", [LoginController::class, "entrar"]);
/** LOGIN */


/** ROTAS PROTEGIDAS POR TOKEN */
Route::middleware(ValidateToken::class)->group(function () {

    /** LOGOUT */
    Route::post("sair", [LoginController::class, "sair"]);
    /** LOGOUT */
});


/** ADMIN */
Route::apiResource("admin", AdminController::class);
/** ADMIN */

/** USUARIO */
Route::apiResource("usuario", UsuarioController::class);
/** USUARIO */

/** LOJA */
Route::apiResource("loja", LojaController::class);
/** LOJA */

/** VENDEDOR */
Route::apiResource("vendedor", VendedorController::class);
/** VENDEDOR */

/** EVENTO */
Route::apiResource("evento", EventoController::class);
/** EVENTO */

/** CIDADE */
Route::apiResource("cidade", CidadeController::class);
/** CIDADE */

/** ROTAS */
Route::apiResource("rotas", RotaController::class);
/** ROTAS */
