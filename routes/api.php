<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Login\LoginController;
use App\Http\Controllers\Loja\LojaController;
use App\Http\Controllers\Usuario\UsuarioController;
use App\Http\Controllers\Vendedor\VendedorController;
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

/** LOGIN */
Route::apiResource("login", LoginController::class);
/** LOGIN */

