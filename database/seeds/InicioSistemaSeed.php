<?php

use Illuminate\Database\Seeder;

class InicioSistemaSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $especialidad1 = factory(\App\Especialidad::class)->create();
        $especialidad2 = factory(\App\Especialidad::class)->create();
        $especialidad3 = factory(\App\Especialidad::class)->create();
        $especialidad4 = factory(\App\Especialidad::class)->create();
        $especialidad5 = factory(\App\Especialidad::class)->create();
        $especialidad6 = factory(\App\Especialidad::class)->create();
        $especialidad7 = factory(\App\Especialidad::class)->create();
        $especialidad8 = factory(\App\Especialidad::class)->create();

        $a = collect($especialidad1->id,
            $especialidad2->id,
            $especialidad3->id,
            $especialidad4->id,
            $especialidad5->id,
            $especialidad6->id,
            $especialidad7->id,
            $especialidad8->id
        )->toArray();

        $climed1 = factory(\App\Climed::class)->create();
        $climed2 = factory(\App\Climed::class)->create();
        $climed3 = factory(\App\Climed::class)->create();
        $climed4 = factory(\App\Climed::class)->create();
        $climed5 = factory(\App\Climed::class)->create();
        $climed6 = factory(\App\Climed::class)->create();
        $climed7 = factory(\App\Climed::class)->create();
        $climed8 = factory(\App\Climed::class)->create();


        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();
        $solicitud = factory(\App\Solicitud::class)->create();



        $climed1->especialidades()->attach($a);
        $climed2->especialidades()->attach($a);
        $climed3->especialidades()->attach($a);
        $climed4->especialidades()->attach($a);
        $climed5->especialidades()->attach($a);
        $climed6->especialidades()->attach($a);
        $climed7->especialidades()->attach($a);
        $climed8->especialidades()->attach($a);



    }
}
