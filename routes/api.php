<?php

use Illuminate\Http\Request;

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
Route::post('/login', 'UserController@login');
Route::post('/register', 'UserController@register');


//Route::group(['middleware'=> 'auth:api'],function()
//{
//Rutas para buscar un cliente a través de la cédula y no del id
Route::post('/cedulaclientes', 'ClienteController@buscarcedula');
Route::get('/cedulaclientes/{cedulacliente}', 'ClienteController@verporcedula');

//Ruta para ver un plato por el tipo
Route::get('/tipoplatos/{tipoplato}', 'PlatoController@tipoplatos');
//Ruta para ver un plato por el id del pedido
Route::get('/platopedidos/{platopedido}', 'DetalleController@platospedidos');

//Actualizamos el id de la Factura en detalle por medio del id del pedido
Route::patch('acfacdetalles/{acfacdetalle}', 'DetalleController@actualizarfac');

//Buscamos una factura en base a la cédula del cliente
Route::get('clifacs/{clifac}', 'ClienteController@clifacs');
//Rutas tipo Resource
Route::apiResource('/clientes', 'ClienteController');
Route::apiResource('/mesas', 'MesaController');
Route::apiResource('/empleados', 'EmpleadoController');
Route::apiResource('/platos', 'PlatoController');
Route::apiResource('/facs', 'FacController');
Route::apiResource('/estados', 'EstadoController');
Route::apiResource('/pedidos', 'PedidoController');
Route::apiResource('/detalles', 'DetalleController');
//});
