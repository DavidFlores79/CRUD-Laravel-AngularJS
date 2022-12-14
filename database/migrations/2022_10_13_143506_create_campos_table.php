<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCamposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('campos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('etiqueta')->nullable();
            $table->string('descripcion')->nullable();
            $table->bigInteger('tipo_formulario_id')->unsigned();
            $table->bigInteger('tipo_campo_id')->unsigned();
            
            $table->boolean('requerido')->default(0);
            $table->boolean('visible')->default(1);    
            $table->integer('minlength')->nullable();
            $table->integer('min')->nullable();
            $table->boolean('sololectura')->default(0);
            $table->string('ng_options')->nullable();
            
            //superusuarios unicamente podran habilitarlos     
            $table->boolean('obligatorio')->default(0);
            $table->boolean('estatus')->default(1);
            $table->timestamps();
        });

        Schema::table('campos', function($table) {
            $table->foreign('tipo_formulario_id')->references('id')->on('tipo_formularios')->onDelete('cascade');
        });
        Schema::table('campos', function($table) {
            $table->foreign('tipo_campo_id')->references('id')->on('tipo_campos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('campos');
    }
}
