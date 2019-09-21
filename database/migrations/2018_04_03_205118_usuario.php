<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuario extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');

        Schema::create('Usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->char('name', 100)->unique();
            $table->string('email');
            $table->text('password');
            $table->string('remember_token')->nullable();
            $table->integer('id_perfil')->unsigned();
            $table->foreign('id_perfil')->references('id')->on('Perfiles');
            $table->timestamps();
            $table->timestamp('deleted_at')->nullable();
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

        Schema::dropIfExists('Usuarios');
        DB::statement('SET FOREIGN_KEY_CHECKS = 1');
    }
}
