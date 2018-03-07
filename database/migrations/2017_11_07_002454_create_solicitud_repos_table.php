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
        Schema::create('solicitudes', function (Blueprint $table) {
            $table->increments('IDS');
            $table->string('MEDICO');
            $table->date('FECHAS');
            $table->string('ESTADO');
            $table->integer('ASIGNADO');
            $table->integer('IDAFILIADO')->unsigned();
            $table->foreign('IDAFILIADO')->references('ID')->on('afiliados');
            $table->integer('IDCLIMED')->unsigned();
            $table->foreign('IDCLIMED')->references('IDCLI')->on('climed');
            $table->integer('ESPECIALIDAD')->unsigned();
            $table->foreign('ESPECIALIDAD')->references('IDESPECIALIDAD')->on('especialidades');
            $table->integer('TIPO');
            $table->string('FOTO');
            $table->integer('REVISADO');
            $table->string('OBS');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::dropIfExists('solicitudes');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
