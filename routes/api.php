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

    $dato = array('IDCLIMED' => 1, 'ESPECIALIDAD' => 1, 'DNISOLICITANTE' => 3, 'IDAFILIADO' => 3, 'MEDICO' => 'asdfas', 'FECHAS' => \Carbon\Carbon::today()->toDateString(), 'ESTADO' => 'Pendiente');

    $client = new Client();
    $r = $client->post( 'http://des.gestionarturnos.com/solicitud/createClinico', ['json' => $dato, 'allow_redirects' => false, 'headers' => ['Authorization' => 'Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vZGVzLmdlc3Rpb25hcnR1cm5vcy5jb20vbG9naW4iLCJpYXQiOjE1MjM5MTkyNzcsIm5iZiI6MTUyMzkxOTI3NywianRpIjoid1RXYVgyMGJsRzY3b3NLeSIsInN1YiI6MSwicHJ2IjoiODdlMGFmMWVmOWZkMTU4MTJmZGVjOTcxNTNhMTRlMGIwNDc1NDZhYSIsInBlcm1pc29zIjpbImFmaWxpYWRvIiwiY2xpbWVkIiwic29saWNpdHVkIiwibWVkaWNvcyIsImZhcm1hY2lhIiwidXNlciIsImVzcGVjaWFsaWRhZCIsImF1ZGl0b3JpYSIsInJlY29tZW5kYWNpb24iLCJyZXBvcnRlU29saWNpdHVkZXMiXSwidXNlcl9pZCI6MX0.6kfl0LF-lxz1fcsNZySTVlDP1ZpkiO3D6bHJ_or38cA']]);

    return $r;
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
Route::resource('solicitud', 'SolicitudController');

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

//FARMACIA

Route::get('farmaciaApp/all', 'Aplicacion\AppFarmaciaController@all');

//RECOMENDACION

Route::post('recomendacionApp', 'Aplicacion\AppRecomendacionController@create');


Route::get('cobertec/clinicas', 'Cobertec\ClimedController@clinicas');
Route::get('cobertec/farmacias', 'Cobertec\ClimedController@farmacias');