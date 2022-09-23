<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterialsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('codigo', 255);
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->string('propietario', 255);
            $table->unsignedBigInteger('puesto_vigilancia_id');
            $table->date('fecha_registro');
            $table->timestamps();

            $table->foreign('puesto_vigilancia_id')->on('puesto_vigilancias')->references('id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('materials');
    }
}
