<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', 'HomeController@index');

// Cotizaciones
Route::get('cotizaciones', 'EstimateController@index');
Route::post('cotizaciones', 'EstimateController@store');
Route::get('cotizaciones/nuevo', 'EstimateController@create');
Route::patch('cotizaciones/{estimate}', 'EstimateController@update');
Route::get('cotizaciones/{estimate}', 'EstimateController@show');
Route::delete('cotizaciones/{estimate}', 'EstimateController@destroy');
Route::get('cotizaciones/{estimate}/editar', 'EstimateController@edit');
Route::get('cotizaciones/{estimate}/download', 'EstimateController@download');
Route::get('cotizaciones/{estimate}/pdf', 'EstimateController@pdf');
Route::post('cotizaciones/{estimate}/email', 'EstimateController@email');

// Clientes
Route::get('clientes', 'ClientController@index');
Route::post('clientes', 'ClientController@store');
Route::get('clientes/nuevo', 'ClientController@create');
Route::patch('clientes/{client}', 'ClientController@update');
Route::get('clientes/{client}', 'ClientController@show');
Route::delete('clientes/{client}', 'ClientController@destroy');
Route::get('clientes/{client}/editar', 'ClientController@edit');
Route::get('clientes/getClientById/{id}', 'ClientController@getClientById');

// Marcas
Route::get('marcas', 'BrandController@index');
Route::post('marcas', 'BrandController@store');
Route::get('marcas/nuevo', 'BrandController@create');
Route::patch('marcas/{brand}', 'BrandController@update');
Route::get('marcas/{brand}', 'BrandController@show');
Route::delete('marcas/{brand}', 'BrandController@destroy');
Route::get('marcas/{brand}/editar', 'BrandController@edit');

// Categorías
Route::get('categorias', 'CategoryController@index');
Route::post('categorias', 'CategoryController@store');
Route::get('categorias/nuevo', 'CategoryController@create');
Route::patch('categorias/{category}', 'CategoryController@update');
Route::get('categorias/{category}', 'CategoryController@show');
Route::delete('categorias/{category}', 'CategoryController@destroy');
Route::get('categorias/{category}/editar', 'CategoryController@edit');

// Monedas
Route::get('monedas', 'CurrencyController@index');
Route::post('monedas', 'CurrencyController@store');
Route::get('monedas/nuevo', 'CurrencyController@create');
Route::patch('monedas/{currency}', 'CurrencyController@update');
Route::get('monedas/{currency}', 'CurrencyController@show');
Route::delete('monedas/{currency}', 'CurrencyController@destroy');
Route::get('monedas/{currency}/editar', 'CurrencyController@edit');

// Usuarios
Route::get('usuarios', 'UserController@index');
Route::post('usuarios', 'UserController@store');
Route::get('usuarios/nuevo', 'UserController@create');
Route::patch('usuarios/{user}', 'UserController@update');
Route::get('usuarios/{user}', 'UserController@show');
Route::delete('usuarios/{user}', 'UserController@destroy');
Route::get('usuarios/{user}/editar', 'UserController@edit');

// Productos
Route::get('productos', 'ProductController@index');
Route::post('productos', 'ProductController@store');
Route::get('productos/nuevo', 'ProductController@create');
Route::patch('productos/{product}', 'ProductController@update');
Route::delete('productos/{product}', 'ProductController@destroy');
Route::get('productos/{product}/editar', 'ProductController@edit');
Route::get('productos/getProducts', 'ProductController@getProducts');
Route::get('productos/getProductById/{id}', 'ProductController@getProductById');

// Ajustes
Route::get('ajustes', 'SettingController@index');
Route::patch('ajustes/{setting}', 'SettingController@update');
