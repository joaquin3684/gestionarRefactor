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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Turnos', function (Blueprint $table) {
            $table->increments('IDT');
            $table->integer('IDSOLICITUD')->unsigned();
            $table->foreign('IDSOLICITUD')->references('IDS')->on('Solicitudes');
            $table->date('FECHAT');
            $table->date('FECHACREACION');
            $table->time('HORAT');
            $table->integer('CONFIRMACION');
            $table->string('MOTIVOT')->nullable();
            $table->string('MEDICOASIGNADO');
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

        Schema::dropIfExists('Turnos');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
