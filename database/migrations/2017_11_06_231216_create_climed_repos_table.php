<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClimedReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Climed', function (Blueprint $table) {
            $table->increments('IDCLI');
            $table->string('NOMBRE');
            $table->string('DIRECCION');
            $table->string('LOCALIDAD');
            $table->string('ZONA');
            $table->integer('PARTICULAR');
            $table->double('latitude');
            $table->double('longitude');
            $table->integer('TELEFONO');
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

        Schema::dropIfExists('Climed');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}
