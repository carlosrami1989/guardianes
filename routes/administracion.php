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
Route::group(['prefix' => 'modulos/sorteo'], function () {

    
    Route::namespace('Modulos\Administracion')->prefix('copedesa')->group(function () {
       
        //resrvaciones

        Route::get('consulta_usuario/{cedula}', 'Dashboard@ConsultarUsuarioBase');
        Route::post('PostIngresar', 'Dashboard@PostValidarUsuario');
        Route::post('PostLogin', 'Dashboard@ConsultarInicioSession');
        Route::post('PostVerificacionCodigo', 'Dashboard@ConsultarCodigos');
        Route::post('InsertCodigos', 'Dashboard@InsertarCodigosCodigos');
        Route::post('PostActualizarDatos', 'Dashboard@PostActualizarUsuario');
        Route::post('PostActualizarPassword', 'Dashboard@PostActualizarContrasena');
        Route::get('consulta_usuario_recovery/{cedula}', 'Dashboard@ConsultarCedulaRecovery');
        Route::get('PostRecovery', 'Dashboard@RecoveryCuenta');

        // dashboard
        Route::get('datosEstaciones/{fechainicio}/{fechafin}', 'Dashboard@ConsultarDatosEstaciones');
        Route::get('datosEstacionesidentificacion/{identificacion}', 'Dashboard@ConsultarDatosEstacionesIdentificacion');




        // Route::get('GetSucursal', 'ReservacionController@GetSucursal');
        // Route::get('GetMesasPorSucursal/{id_sucursal}', 'ReservacionController@GetMesasPorSucursal');
        // Route::get('GetValidarUsuario/{cedula}/{correo}/{telefono}/{nombres}/{apellidos}', 'ReservacionController@GetValidarUsuario');
        // Route::post('GetValidarUsuario', 'ReservacionController@GetValidarUsuario');
        // Route::post('PostValidarUsuarioCliente', 'ReservacionController@PostValidarUsuarioCliente');
        // Route::post('PostValidarUsuario', 'ReservacionController@PostValidarUsuario');
        // Route::get('GetFechaReserva/{fecha}/{local}/{mesa}', 'ReservacionController@GetFechaReserva');
        // Route::get('GetCliente/{cedula}', 'ReservacionController@GetCliente');

    });
   });



   


   
   