<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmaciasReposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Farmacias', function (Blueprint $table) {
            $table->increments('ID');
            $table->string('NOMBRE');
            $table->string('DIRECCION');
            $table->string('LOCALIDAD');
            $table->string('ZONA');
            $table->double('latitude');
            $table->double('longitude');
            $table->string('TELEFONO');
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

        Schema::dropIfExists('Farmacias');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

    }
}