<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnoReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('turnos', function (Blueprint $table) {
            $table->increments('IDT');
            $table->integer('IDSOLICITUD')->unsigned();
            $table->foreign('IDSOLICITUD')->references('IDS')->on('solicitudes');
            $table->date('FECHAT');
            $table->time('HORAT');
            $table->integer('CONFIRMACION');
            $table->string('MOTIVOT');
            $table->integer('MEDICOASIGNADO')->unsigned();
            $table->foreign('MEDICOASIGNADO')->references('IDCLI')->on('climed');
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

        Schema::dropIfExists('turnos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
