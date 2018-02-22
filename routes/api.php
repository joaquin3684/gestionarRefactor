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

Route::get('afiliado/traerElementos', 'AfiliadoController@all');
Route::resource('afiliado', 'AfiliadoController');

//------------------ RECOMENDACION -------------------------

Route::get('recomendacion/traerElementos', 'RecomendacionController@all');
Route::resource('recomendacion', 'RecomendacionController');

//--------------------- CLIMED ------------------------

Route::get('climed/traerElementos', 'ClimedController@all');

Route::resource('climed', 'ClimedController');

//--------------------- SOLICITUD --------------------

Route::get('solicitud/traerElementos', 'SolicitudController@all');

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

//----------------------- APLICACION CELULAR -------------------------

// SOLICITUDES

Route::post('solicitud/pendientesyabiertas', 'Aplicacion\AppSolicitudController@pendientesOAbiertas');
Route::get('solicitud/solicitudApp/{id}', 'Aplicacion\AppSolicitudController@findApp');
Route::post('solicitud/confirmar', 'Aplicacion\AppSolicitudController@confirmarSolicitud');
Route::post('solicitud/rechazar', 'Aplicacion\AppSolicitudController@confirmarSolicitud');


// CLIMED

Route::get('climed/clinicasPorEspecialidad/{id}', 'Aplicacion\AppClimedController@findClinicasByEspecialidad');
Route::post('climed/clinicasPorEspecialidadYLocalidad', 'Aplicacion\AppClimedController@findClinicasByEspecialidad');