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

Route::get('/', 'WelcomeController@index');

Route::get('home', 'HomeController@index');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('Cxc', 'CxcController@index');

Route::get('nuevoMovimiento', 'MovController@index');

Route::get('documentos', function(){
	//$documents = array('' => , );
	$arrayName = array('id' => 0, 'name' => "Item 0", "delete" => "<div class = 'deleterow'><div class='glyphicon glyphicon-remove'></div></div>" );
    return response() -> json([$arrayName]);
});