<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAfiliadoReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('afiliados', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('DNI');
            $table->string('NOMBRE');
            $table->string('APELLIDO');
            $table->string('EMAIL');
            $table->integer('TELEFONO');
            $table->integer('CELULAR');
            $table->string('DIRECCION');
            $table->string('PISO')->nullable();
            $table->string('DEPARTAMENTO')->nullable();
            $table->date('NACIMIENTO');
            $table->bigInteger('CUIL');
            $table->integer('GRUPOF')->nullable();
            $table->string('NAFILIADO');
            $table->integer('IDOBRASOCIAL')->unsigned();
            $table->foreign('IDOBRASOCIAL')->references('ID')->on('obras_sociales');
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

        Schema::dropIfExists('afiliados');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
