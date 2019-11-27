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

Route::group(['middeware' => ['guest']],function(){
  Route::get('/', 'Auth\LoginController@showLoginForm');
  Route::post('/login', 'Auth\LoginController@login')->name('login');

});

  Route::group(['middeware' => ['auth']],function(){

  Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

  Route::get('/main', function () {
      return view('contenedor/contenedor');
  })->name('main'); //alias

  Route::group(['middeware' => ['Almacenero']],function(){

    Route::get('/articulo', 'ArticuloControlador@index');
    Route::post('/articulo/registrar', 'ArticuloControlador@store');
    Route::put('/articulo/actualizar', 'ArticuloControlador@update');
    Route::put('/articulo/activar', 'ArticuloControlador@activar');
    Route::put('/articulo/desactivar', 'ArticuloControlador@desactivar');
    Route::get('/articulo/buscarArticulo', 'ArticuloControlador@buscarArticulo');


    //Proveedor
    Route::get('/proveedor', 'ProveedorControlador@index');
    Route::post('/proveedor/registrar', 'ProveedorControlador@store');
    Route::put('/proveedor/actualizar', 'ProveedorControlador@update');
    Route::get('/proveedor/selectProveedor', 'ProveedorControlador@selectProveedor');

    //
    Route::get('/ingreso', 'IngresoControlador@index');
    Route::post('/ingreso/registrar', 'IngresoControlador@store');
    Route::put('/ingreso/desactivar', 'IngresoControlador@desactivar');
  //  Route::get('/ingreso', 'IngresoControlador@index');

  });

  Route::group(['middeware' => ['Vendedor']],function(){

      //Cliente
      Route::get('/cliente', 'ClienteControlador@index');
      Route::post('/cliente/registrar', 'ClienteControlador@store');
      Route::put('/cliente/actualizar', 'ClienteControlador@update');

    });

  Route::group(['middeware' => ['Administrador']],function(){

    Route::get('/cliente', 'ClienteControlador@index');
    Route::post('/cliente/registrar', 'ClienteControlador@store');
    Route::put('/cliente/actualizar', 'ClienteControlador@update');

    Route::get('/articulo', 'ArticuloControlador@index');
    Route::post('/articulo/registrar', 'ArticuloControlador@store');
    Route::put('/articulo/actualizar', 'ArticuloControlador@update');
    Route::put('/articulo/activar', 'ArticuloControlador@activar');
    Route::put('/articulo/desactivar', 'ArticuloControlador@desactivar');
    Route::get('/articulo/buscarArticulo', 'ArticuloControlador@buscarArticulo');
    //Proveedor
    Route::get('/proveedor', 'ProveedorControlador@index');
    Route::post('/proveedor/registrar', 'ProveedorControlador@store');
    Route::put('/proveedor/actualizar', 'ProveedorControlador@update');
    Route::get('/proveedor/selectProveedor', 'ProveedorControlador@selectProveedor');


    Route::get('/rol', 'RolControlador@index');
    Route::get('/rol/selectRol', 'RolControlador@selectRol');

    //users
    Route::get('/user', 'UserControllador@index');
    Route::post('/user/registrar', 'UserControllador@store');
    Route::put('/user/actualizar', 'UserControllador@update');
    Route::put('/user/activar', 'UserControllador@activar');
    Route::put('/user/desactivar', 'UserControllador@desactivar');


    Route::get('/ingreso', 'IngresoControlador@index');
    Route::post('/ingreso/registrar', 'IngresoControlador@store');
    Route::put('/ingreso/desactivar', 'IngresoControlador@desactivar');

  });


});

//Route::get('/home', 'HomeController@index')->name('home');
