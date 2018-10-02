<?php

use App\Services\UserFromToken;
use GuzzleHttp\Client;
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

//--------------------- LOGIN ----------------------------

Route::get('prueba', function(){

return 'juan puto';
});


Route::get('sacarRepetidosRelacionMedicos', function(){

  /*  $clinica = \App\Climed::with('especialidades')->find(5);
    $clinica->especialidades()->detach([101, 14]);*/

    $clinicas = \App\Climed::with('especialidades')->get();
    $clinicas->each(function($clinica){
        $idsEspeciliadaesUnicas = $clinica->especialidades->map(function($especiliadad){ return $especiliadad->IDESPECIALIDAD; })->unique();
        $clinica->especialidades()->detach($idsEspeciliadaesUnicas);
        $clinica->especialidades()->attach($idsEspeciliadaesUnicas->toArray());
    });
return 1;

});

Route::get('ponerClinicas', function(){

    $climeds = \App\Climed::all();
    $climeds->each(function($cli){
        $cli->obrasSociales()->attach(1);
    });
    return 1;
});

Route::post('importarAfiliados', 'ImportacionController@importarAfiliados');

Route::get('ponerFarmacias', function(){

    $farmacias = \App\Farmacia::all();
    $farmacias->each(function($farmacia){
        $farmacia->obrasSociales()->attach(1);
    });
    return 1;
});


Route::post('login', 'LoginController@login');

Route::get('mierda', function(){
   return 1;
});

Route::group(['middleware' => ['permisos', 'jwt.auth']], function(){


//-------------------- AFILIADO -----------------------

Route::get('afiliado/traerElementos', 'AfiliadoController@all');
Route::resource('afiliado', 'AfiliadoController');

//--------------------- FARMACIA ------------------------

Route::get('farmacia/traerElementos', 'FarmaciaController@all');
Route::resource('farmacia', 'FarmaciaController');

//------------------ RECOMENDACION -------------------------

Route::get('recomendacion/traerElementos', 'RecomendacionController@all');
Route::post('recomendacion/contactado', 'RecomendacionController@contactado');
Route::get('recomendacion/sinContactar', 'RecomendacionController@recomendacionesSinContactar');
Route::resource('recomendacion', 'RecomendacionController');

//--------------------- CLIMED ------------------------

Route::get('climed/traerElementos', 'ClimedController@all');
Route::resource('climed', 'ClimedController');

//--------------------- SOLICITUD --------------------

Route::get('solicitud/traerElementos', 'SolicitudController@all');
Route::post('solicitud/abrir', 'SolicitudController@abrir');
Route::post('solicitud/autorizar', 'SolicitudController@autorizar');
Route::post('solicitud/rechazar', 'SolicitudController@rechazar');
Route::get('solicitud/solicitudesEnProceso', 'SolicitudController@solicitudesEnProceso');
Route::get('solicitud/solicitudesParaAuditar', 'SolicitudController@solicitudesParaAuditar');

//---------------------- TURNO ------------------------

Route::get('turno/traerElementos', 'TurnoController@all');
Route::post('turno/modificar', 'TurnoController@update');
Route::resource('turno', 'TurnoController');

//--------------------- ESPECIALIDAD --------------------

Route::get('especialidad/traerElementos', 'EspecialidadController@all');
Route::resource('especialidad', 'EspecialidadController');

//-------------------- OBRA SOCIAL ----------------------

Route::get('obraSocial/traerElementos', 'ObraSocialController@all');
Route::resource('obraSocial', 'ObraSocialController');

//------------------ USER --------------------------------

Route::get('user/traerElementos', 'UserController@all');
Route::post('user/cambiarPassword', 'UserController@cambiarContraseña');
Route::resource('user', 'UserController');

//-------------------- PERFIL --------------------------

Route::get('perfil/traerElementos', 'PerfilController@all');


//---------------------- REPORTE SOLICITUDES --------------

    Route::post('reporteSolicitudes/zonas', 'ReporteSolicitudesController@porZona');
Route::post('reporteSolicitudes/clinicas', 'ReporteSolicitudesController@porClinica');
Route::post('reporteSolicitudes/solicitudes', 'ReporteSolicitudesController@porSolicitud');
Route::post('reporteSolicitudes/turnos', 'ReporteSolicitudesController@porTurnos');


//---------------------- AUDITORIA --------------------------
    Route::post('auditoria/autorizarEstudio', 'SolicitudController@autorizarEstudio');

});

//----------------------- APLICACION CELULAR -------------------------

// SOLICITUDES
Route::get('solicitud/obtenerFamiliares', 'Aplicacion\AppSolicitudController@obtenerFamiliares');
Route::get('solicitud/pendientesyabiertas/{dni}', 'Aplicacion\AppSolicitudController@pendientesOAbiertas');
Route::get('solicitud/solicitudApp/{id}', 'Aplicacion\AppSolicitudController@findApp');
Route::get('solicitud/enespera/{dni}', 'Aplicacion\AppSolicitudController@enEspera');
Route::get('solicitud/confirmadas/{dni}', 'Aplicacion\AppSolicitudController@confirmadas');
Route::get('solicitud/rechazadas/{dni}', 'Aplicacion\AppSolicitudController@rechazadas');

Route::post('solicitud/createClinico', 'Aplicacion\AppSolicitudController@storeClinico');
Route::post('solicitud/createEspecialidad', 'Aplicacion\AppSolicitudController@storeEspecialidad');
Route::post('solicitud/createEstudio', 'Aplicacion\AppSolicitudController@storeEstudio');
Route::post('solicitud/uploadFile', 'Aplicacion\AppSolicitudController@uploadFile');

Route::post('turno/confirmar', 'Aplicacion\AppSolicitudController@confirmarTurno');
Route::post('turno/rechazar', 'Aplicacion\AppSolicitudController@rechazarTurno');

// CLIMED

Route::get('climedApp/all', 'Aplicacion\AppClimedController@all');
Route::get('climedApp/allParticulares', 'Aplicacion\AppClimedController@allParticulares');
Route::get('climedApp/{id}', 'Aplicacion\AppClimedController@find');
Route::get('climedApp/especialidades/{id}', 'Aplicacion\AppClimedController@especialidadesClinica');
Route::get('climedApp/localidades/{idEspecialidad}', 'Aplicacion\AppClimedController@localidadesEspecialidad');
Route::get('climedApp/ag', 'Aplicacion\AppClimedController@localidadesEspecialidadClinico');
Route::get('climedApp/clinicasPorEspecialidad/{id}', 'Aplicacion\AppClimedController@findClinicasByEspecialidad');

Route::post('climedApp/clinicasPorEspecialidadYLocalidad', 'Aplicacion\AppClimedController@findClinicasByEspecialidadAndLocalidad');




Route::get('especialidadApp/all', 'Aplicacion\AppClimedController@especialidades');
Route::get('especialidadApp/localidades/{idEspecialidad}', 'Aplicacion\AppClimedController@localidadesEspecialidad');

Route::post('afiliado/modificarEmail', 'Aplicacion\AppAfiliadoController@modificarEmail');


//FARMACIA

Route::get('farmaciaApp/all', 'Aplicacion\AppFarmaciaController@all');

//RECOMENDACION

Route::post('recomendacionApp', 'Aplicacion\AppRecomendacionController@create');


// COBERTEC WEB

Route::get('cobertec/clinicas', 'Cobertec\ClimedController@clinicas');
Route::get('cobertec/farmacias', 'Cobertec\ClimedController@farmacias');


// SANATORIAL WEB

Route::get('sanatorial/clinicas', 'Sanatorial\ClimedController@clinicas');
Route::get('sanatorial/farmacias', 'Sanatorial\ClimedController@farmacias');

Route::resource('solicitud', 'SolicitudController');
