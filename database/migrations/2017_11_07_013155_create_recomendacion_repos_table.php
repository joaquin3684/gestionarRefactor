<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRecomendacionReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recomendaciones', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('NOMBRE');
            $table->string('APELLIDO');
            $table->string('NRO');
            $table->date('FECHA');
            $table->integer('CONTACTADO');
            $table->string('COMENTARIO');
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

        Schema::dropIfExists('recomendaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
