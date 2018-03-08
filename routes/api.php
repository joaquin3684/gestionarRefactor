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
//-------------------- AFILIADO -----------------------
Route::get('climed/traerElementos', 'ClimedController@all');

Route::get('afiliado/traerElementos', 'AfiliadoController@all');
Route::resource('afiliado', 'AfiliadoController');

//------------------ RECOMENDACION -------------------------

Route::get('recomendacion/traerElementos', 'RecomendacionController@all');
Route::resource('recomendacion', 'RecomendacionController');

//--------------------- CLIMED ------------------------


Route::resource('climed', 'ClimedController');

//--------------------- SOLICITUD --------------------

Route::get('solicitud/traerElementos', 'SolicitudController@all');
Route::post('solicitud/autorizar', 'SolicitudController@autorizar');
Route::post('solicitud/rechazar', 'SolicitudController@rechazar');
Route::get('solicitud/solicitudesEnProceso', 'SolicitudController@solicitudesEnProceso');
Route::resource('solicitud', 'SolicitudController');

//---------------------- TURNO ------------------------

Route::get('turno/traerElementos', 'TurnoController@all');
Route::resource('turno', 'TurnoController');

//--------------------- ESPECIALIDAD --------------------

Route::get('especialidad/traerElementos', 'EspecialidadController@all');
Route::resource('especialidad', 'EspecialidadController');

//-------------------- OBRA SOCIAL ----------------------
Route::get('obraSocial/traerElementos', 'ObraSocialController@all');
Route::resource('obraSocial', 'ObraSocialController');

//--------------------- LOGIN ----------------------------

Route::post('usuario/registrar', 'LoginController@registrar');
Route::post('usuario/login', 'LoginController@login');
Route::post('usuario/logout', 'LoginController@logout');


//------------------ USER --------------------------------

Route::get('user/traerElementos', 'UserController@all');
Route::resource('user', 'UserController');

//------------------ ROLES -----------------------------

Route::get('role/traerElementos', 'RoleController@all');
Route::resource('role', 'RoleController');

//------------------ PERMISOS -----------------------------

Route::get('permiso/traerElementos', 'PermissionController@all');
Route::resource('permiso', 'PermissionController');


//----------------------- APLICACION CELULAR -------------------------

// SOLICITUDES

Route::post('solicitud/pendientesyabiertas', 'Aplicacion\AppSolicitudController@pendientesOAbiertas');
Route::get('solicitud/solicitudApp/{id}', 'Aplicacion\AppSolicitudController@findApp');


Route::post('turno/confirmar', 'Aplicacion\AppSolicitudController@confirmarTurno');
Route::post('turno/rechazar', 'Aplicacion\AppSolicitudController@rechazarTurno');


// CLIMED

Route::get('climed/clinicasPorEspecialidad/{id}', 'Aplicacion\AppClimedController@findClinicasByEspecialidad');
Route::post('climed/clinicasPorEspecialidadYLocalidad', 'Aplicacion\AppClimedController@findClinicasByEspecialidad');