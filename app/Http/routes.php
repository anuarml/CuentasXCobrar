<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MenuController@index');

//Route::get('/cxc/movimiento/mov/{movID}/buscar/{searchType}','Cxc\MovController@search');
Route::get('/cxc/movimiento/buscar/cliente','Cxc\ClientController@showClientSearch');
Route::get('/cxc/movimiento/mov/{movID}/buscar/sucursal-cliente','Cxc\ClientController@showClientOfficeSearch');
Route::get('/cxc/movimiento/mov/{movID}/buscar/referencia-movimiento','Cxc\MovController@showMovementReferenceSearch');
Route::get('/cxc/movimiento/mov/{movID}/buscar/{searchType}/{row}','Cxc\DocumentController@showDocumentSearch');
Route::get('/cxc/movimiento/mov/{movID}/consultar/saldo-cliente','Cxc\ClientController@showClientBalance');

Route::get('/embarques','Shipment\ShipmentController@showShipmentDocuments');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'cxc/movimiento' => 'Cxc\MovController',
	'cxc/cliente' => 'Cxc\ClientController',
	'cxc/documento' => 'Cxc\DocumentController',
	'utileries' => 'UtileriesController',
	'embarques' => 'Shipment\ShipmentController',
]);

