<?php

use Illuminate\Database\Seeder;
use Faker\Factory as F;
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


        $perfil = factory(\App\Perfil::class)->create();
        $perfilAfiliado = factory(\App\Perfil::class)->create();


        $usuario = factory(\App\User::class)->create(['name' => 1, 'id_perfil' => $perfil->id, 'email' => 1]);
        $usuarioAfiliado = factory(\App\User::class)->create(['name' => "afiliado", 'id_perfil' => $perfilAfiliado->id, 'email' => 2]);
        $afiliado = factory(\App\Afiliado::class)->create(['IDOBRASOCIAL' => $obraSocial->ID, 'id_usuario' => $usuarioAfiliado->id]);

        $obraSocial->usuarios()->attach($usuario->id);
        $obraSocial->usuarios()->attach($usuarioAfiliado->id);
        $obraSocial2->usuarios()->attach($usuario->id);

        $pantalla1 = factory(\App\Pantalla::class)->create(['nombre' => 'afiliado']);
        $pantalla2 = factory(\App\Pantalla::class)->create(['nombre' => 'climed']);
        $pantalla3 = factory(\App\Pantalla::class)->create(['nombre' => 'solicitud']);
        $pantalla4 = factory(\App\Pantalla::class)->create(['nombre' => 'medicos']);
        $pantalla5 = factory(\App\Pantalla::class)->create(['nombre' => 'farmacia']);
        $pantalla6 = factory(\App\Pantalla::class)->create(['nombre' => 'user']);
        $pantalla7 = factory(\App\Pantalla::class)->create(['nombre' => 'especialidad']);
        $pantalla8 = factory(\App\Pantalla::class)->create(['nombre' => 'auditoria']);
        $pantalla9 = factory(\App\Pantalla::class)->create(['nombre' => 'recomendacion']);
        $pantalla10 = factory(\App\Pantalla::class)->create(['nombre' => 'estadisticas']);

        $idsPantallas = array($pantalla1->id, $pantalla2->id, $pantalla3->id, $pantalla4->id, $pantalla5->id, $pantalla6->id, $pantalla7->id, $pantalla8->id, $pantalla9->id, $pantalla10->id);

        $perfilAfiliado->pantallas()->attach($pantalla9);
        $perfil->pantallas()->attach($idsPantallas);

        $ruta1 = factory(\App\Ruta::class)->create(['ruta' => '/obraSocial/traerElementos']);
        $ruta2 = factory(\App\Ruta::class)->create(['ruta' => '/especialidad/traerElementos']);
        $ruta3 = factory(\App\Ruta::class)->create(['ruta' => '/perfil/traerElementos']);
        $ruta4 = factory(\App\Ruta::class)->create(['ruta' => '/turno']);
        $ruta5 = factory(\App\Ruta::class)->create(['ruta' => '/turno/traerElementos']);
        $ruta6 = factory(\App\Ruta::class)->create(['ruta' => '/turno/modificar']);

        $pantalla1->rutas()->attach($ruta1->id);
        $pantalla2->rutas()->attach([$ruta1->id, $ruta2->id]);
        $pantalla3->rutas()->attach([$ruta4->id, $ruta5->id, $ruta6->id]);
        $pantalla5->rutas()->attach($ruta1->id);
        $pantalla6->rutas()->attach([$ruta1->id, $ruta3->id]);


    }
}
