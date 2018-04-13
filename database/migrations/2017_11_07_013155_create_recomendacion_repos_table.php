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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Recomendaciones', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('NOMBRE');
            $table->string('APELLIDO');
            $table->integer('NRO');
            $table->integer('DNIAFILIADO');
            $table->date('FECHA');
            $table->integer('CONTACTADO');
            $table->string('COMENTARIO');
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

        Schema::dropIfExists('Recomendaciones');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
