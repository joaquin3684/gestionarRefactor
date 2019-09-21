<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
use factories\AfiliadoFactory as AF;
use Illuminate\Support\Facades\DB;

class SecuritySeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $obraSocial = factory(\App\ObraSocial::class)->create();
        $obraSocial2 = factory(\App\ObraSocial::class)->create();
        $obraSocial3 = factory(\App\ObraSocial::class)->create();


        $perfil = factory(\App\Perfil::class)->create(['nombre' => 'admin']);
        $perfilAfiliado = factory(\App\Perfil::class)->create(['nombre' => 'afiliado']);
        $perfilAuditor = factory(\App\Perfil::class)->create(['nombre' => 'auditorMedico']);
        $perfilOperador = factory(\App\Perfil::class)->create(['nombre' => 'operador']);

        $usuario = factory(\App\User::class)->create(['name' => 1, 'id_perfil' => $perfil->id, 'email' => 1, 'password' => \Illuminate\Support\Facades\Hash::make("1")]);
        $usuarioAuditor = factory(\App\User::class)->create(['name' => 'auditor', 'id_perfil' => $perfilAuditor->id, 'email' => 1]);
        $usuarioAfiliado = factory(\App\User::class)->create(['name' => "afiliado", 'id_perfil' => $perfilAfiliado->id, 'email' => 2]);
        $usuarioOperador = factory(\App\User::class)->create(['name' => 'operador', 'id_perfil' => $perfilOperador->id, 'email' => 3]);
        $afiliado = factory(\App\Afiliado::class)->create(['IDOBRASOCIAL' => $obraSocial->ID, 'id_usuario' => $usuarioAfiliado->id]);

        $obraSocial->usuarios()->attach($usuario->id);
        $obraSocial2->usuarios()->attach($usuario->id);
        $obraSocial->usuarios()->attach($usuarioAuditor->id);
        $obraSocial2->usuarios()->attach($usuarioAuditor->id);
        $obraSocial->usuarios()->attach($usuarioOperador->id);
        $obraSocial->usuarios()->attach($usuarioAfiliado->id);

        $pantalla1 = factory(\App\Pantalla::class)->create(['nombre' => 'afiliado']);
        $pantalla2 = factory(\App\Pantalla::class)->create(['nombre' => 'climed']);
        $pantalla3 = factory(\App\Pantalla::class)->create(['nombre' => 'solicitud']);
        $pantalla4 = factory(\App\Pantalla::class)->create(['nombre' => 'medicos']);
        $pantalla5 = factory(\App\Pantalla::class)->create(['nombre' => 'farmacia']);
        $pantalla6 = factory(\App\Pantalla::class)->create(['nombre' => 'user']);
        $pantalla7 = factory(\App\Pantalla::class)->create(['nombre' => 'especialidad']);
        $pantalla8 = factory(\App\Pantalla::class)->create(['nombre' => 'auditoria']);
        $pantalla9 = factory(\App\Pantalla::class)->create(['nombre' => 'recomendacion']);
        $pantalla10 = factory(\App\Pantalla::class)->create(['nombre' => 'reporteSolicitudes']);
        $pantalla11 = factory(\App\Pantalla::class)->create(['nombre' => 'historialCompleto']);
        $pantalla12 = factory(\App\Pantalla::class)->create(['nombre' => 'hauditoria']);

        $idsPantallas = array($pantalla1->id, $pantalla2->id, $pantalla3->id, $pantalla4->id, $pantalla5->id, $pantalla6->id, $pantalla7->id, $pantalla8->id, $pantalla9->id, $pantalla10->id, $pantalla11->id, $pantalla12->id);

        $perfilAfiliado->pantallas()->attach($pantalla9->id);
        $perfil->pantallas()->attach($idsPantallas);
        $perfilAuditor->pantallas()->attach($pantalla8->id);
        $perfilOperador->pantallas()->attach($pantalla3->id);

        $ruta1 = factory(\App\Ruta::class)->create(['ruta' => '/obraSocial/traerElementos']);
        $ruta2 = factory(\App\Ruta::class)->create(['ruta' => '/especialidad/traerElementos']);
        $ruta3 = factory(\App\Ruta::class)->create(['ruta' => '/perfil/traerElementos']);
        $ruta4 = factory(\App\Ruta::class)->create(['ruta' => '/turno']);
        $ruta5 = factory(\App\Ruta::class)->create(['ruta' => '/turno/traerElementos']);
        $ruta6 = factory(\App\Ruta::class)->create(['ruta' => '/turno/modificar']);
        $ruta7 = factory(\App\Ruta::class)->create(['ruta' => '/climed/traerElementos']);
        $ruta8 = factory(\App\Ruta::class)->create(['ruta' => '/solicitud/solicitudesParaAuditar']);
        $ruta9 = factory(\App\Ruta::class)->create(['ruta' => '/solicitud/autorizar']);
        $ruta10 = factory(\App\Ruta::class)->create(['ruta' => '/solicitud/rechazar']);


        $pantalla1->rutas()->attach($ruta1->id);
        $pantalla2->rutas()->attach([$ruta1->id, $ruta2->id]);
        $pantalla3->rutas()->attach([$ruta4->id, $ruta5->id, $ruta6->id, $ruta7->id]);
        $pantalla5->rutas()->attach($ruta1->id);
        $pantalla6->rutas()->attach([$ruta1->id, $ruta3->id]);

        $pantalla8->rutas()->attach([$ruta2->id, $ruta7->id, $ruta8->id, $ruta9->id, $ruta10->id]);


    }
}
