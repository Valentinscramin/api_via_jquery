<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/produtos', 'App\Http\Controllers\ProdutosController@indexJson');
Route::post('/produtos/novo', 'App\Http\Controllers\ProdutosController@store');
Route::delete('/produtos/deleta', 'App\Http\Controllers\ProdutosController@destroy');
Route::put('/produtos/atualiza', 'App\Http\Controllers\ProdutosController@update');

