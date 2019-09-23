<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSolicitudReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Solicitudes', function (Blueprint $table) {
            $table->increments('IDS');
            $table->string('MEDICO');
            $table->date('FECHAS');
            $table->date('FECHAMODIFICACION')->nullable();
            $table->string('ESTADO')->nullable();
            $table->integer('ASIGNADO')->nullable();
            $table->integer('DNISOLICITANTE');
            $table->integer('IDAFILIADO');
            $table->integer('IDCLIMED')->unsigned()->nullable();
            $table->foreign('IDCLIMED')->references('IDCLI')->on('Climed');
            $table->integer('ESPECIALIDAD')->unsigned()->nullable();
            $table->foreign('ESPECIALIDAD')->references('IDESPECIALIDAD')->on('Especialidad');
            $table->integer('TIPO');
            $table->string('FOTO')->nullable();
            $table->string('MOTIVO')->nullable();
            $table->string('EQUIVALENCIA')->nullable();
            $table->integer('REVISADO')->default(0);
            $table->string('OBS')->nullable();
            $table->string('RANGO')->nullable();
            $table->string('OBSFAMILIAR')->nullable();
            $table->timestamps();
        });
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('Solicitudes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
