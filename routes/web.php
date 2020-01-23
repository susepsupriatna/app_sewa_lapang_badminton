<?php

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// public route
$router->get('/public/lapang', 'PublicController\LapangController@index');
$router->get('/public/lapang/{id}', 'PublicController\LapangController@show');
$router->get('/public/jadwal', 'PublicController\SewaController@index');
$router->get('/public/lapang/image/{imageName}', 'PublicController\LapangController@image');

// auth route
$router->group(['prefix' => 'auth'], function () use ($router) {
	$router->post('/register','AuthController@register');
	$router->post('/login','AuthController@login');
});

// middleware auth route
$router->group(['middleware' => 'auth'], function () use ($router) {

	// user
	$router->post('/user', 'UsersController@store');
	$router->get('/users', 'UsersController@index');
	$router->get('/user/{id}', 'UsersController@show');
	$router->put('/user/{id}', 'UsersController@update');
	$router->delete('/user/{id}', 'UsersController@destroy');

	// member
	$router->post('/member', 'MembersController@store');
	$router->get('/members', 'MembersController@index');
	$router->get('/member/{id}', 'MembersController@show');
	$router->put('/member/{id}', 'MembersController@update');
	$router->delete('/member/{id}', 'MembersController@destroy');

	// lapang
	$router->post('/lapang', 'LapangController@store');
	$router->get('/lapang', 'LapangController@index');
	$router->get('/lapang/{id}', 'LapangController@show');
	$router->put('/lapang/{id}', 'LapangController@update');
	$router->delete('/lapang/{id}', 'LapangController@destroy');
	$router->get('/lapang/image/{imageName}', 'LapangController@image');

	// sewa
	$router->post('/sewa', 'SewaController@store');
	$router->get('/sewa', 'SewaController@index');
	$router->get('/sewa/{id}', 'SewaController@show');
	$router->put('/sewa/{id}', 'SewaController@update');
	$router->delete('/sewa/{id}', 'SewaController@destroy');

	// pembayaran
	$router->post('/pembayaran', 'PembayaranController@store');
	$router->get('/pembayaran', 'PembayaranController@index');
	$router->get('/pembayaran/{id}', 'PembayaranController@show');
	$router->put('/pembayaran/{id}', 'PembayaranController@update');
	$router->delete('/pembayaran/{id}', 'PembayaranController@destroy');
		
});


	