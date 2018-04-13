<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ClimedEsp extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0');

        Schema::create('ClimedEsp', function (Blueprint $table) {
            $table->increments('ID');
            $table->integer('IDCLIMED')->unsigned();
            $table->foreign('IDCLIMED')->references('IDCLI')->on('Climed');
            $table->integer('IDESP')->unsigned();
            $table->foreign('IDESP')->references('IDESPECIALIDAD')->on('Especialidad');
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

        Schema::dropIfExists('ClimedEsp');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
