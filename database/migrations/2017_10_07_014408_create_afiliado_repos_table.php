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
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Afiliados', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('DNI')->unique();
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
            $table->string('LOCALIDAD');
            $table->string('CP');
            $table->string('PLAN');
            $table->integer('IDOBRASOCIAL')->unsigned();
            $table->foreign('IDOBRASOCIAL')->references('ID')->on('obras_sociales');
            $table->integer('id_usuario')->unsigned()->nullable();
            $table->foreign('id_usuario')->references('id')->on('Usuarios');
            $table->softDeletes();
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

        Schema::dropIfExists('Afiliados');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
