<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FarmaciaObraSocial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Farmacia_obra_social', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('id_farmacia')->unsigned();
            $table->foreign('id_farmacia')->references('ID')->on('Farmacias');
            $table->integer('id_obra_social')->unsigned();
            $table->foreign('id_obra_social')->references('ID')->on('obras_sociales');
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

        Schema::dropIfExists('Farmacia_obra_social');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
