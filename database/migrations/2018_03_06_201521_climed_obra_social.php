<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClimedObraSocial extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('Climed_obra_social', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('IDCLIMED')->unsigned();
            $table->foreign('IDCLIMED')->references('IDCLI')->on('Climed');
            $table->integer('IDOBRASOCIAL')->unsigned();
            $table->foreign('IDOBRASOCIAL')->references('ID')->on('obras_sociales');
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

        Schema::dropIfExists('Climed_obra_social');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
