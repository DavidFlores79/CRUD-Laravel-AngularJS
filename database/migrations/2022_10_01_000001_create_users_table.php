<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('nickname')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('direccion')->nullable();
            $table->string('edad')->nullable();
            $table->bigInteger('perfil_id')->unsigned();
            $table->string('fecha_baja')->nullable();
            $table->boolean('bloqueado')->default(0);
            $table->boolean('estatus')->default(1);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::table('users', function($table) {
            $table->foreign('perfil_id')->references('id')->on('perfiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
