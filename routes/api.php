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

//Endpoints Principais

Route::namespace('\App\Http\Controllers\Api')->group(function(){
    Route::get('/pedidos', 'PedidoController@get_pedidos');//Consulta geral
    Route::get('/pedidos/deletados', 'PedidoController@get_recycle_pedidos');//Consulta deletados
    Route::get('/pedidos/restaurar/{id}', 'PedidoController@restore_pedido');//Restaura um registro a partir do ID
    Route::post('/pedidos', 'PedidoController@set_pedido');//Registra um novo pedido na base de dados
    Route::put('/pedidos', 'PedidoController@update_pedido');//Atualiza um registro
    Route::delete('/pedidos/{id}', 'PedidoController@recycle_pedido');//Reciclar um registro
    Route::delete('/pedidos/force_delete/{id}', 'PedidoController@force_delete');//Forçar a exclusão de um registro
    Route::get('/pedidos/{id}', 'PedidoController@unique_pedido');//Buscar um registro em especifico a partir do ID
});

//Endpoints Integração
Route::namespace('\App\Http\Controllers\Api')->group(function(){
    Route::get('/ibge/externo', 'IbgeController@consulta_ibge');//Consulta externa a API do IBGE
    Route::get('/ibge/interno', 'IbgeController@integrador_ibge');//Integração e consulta interna a base de dados
});
