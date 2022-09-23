<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->id();
            $table->string("nombre", 255);
            $table->string("paterno", 255);
            $table->string("materno", 255)->nullable();
            $table->string("ci", 100);
            $table->string("ci_exp", 20);
            $table->date("fecha_nacimiento");
            $table->double("estatura", 8, 2);
            $table->double("peso", 8, 2);
            $table->string("nacionalidad", 255);
            $table->string("dir", 255);

            $table->string("correo", 255);
            $table->string("fono", 155);
            $table->string("cel", 155);
            $table->enum("tipo", ['SUPERVISOR', 'GUARDIA']);
            $table->enum("habilidad", ['EXPERTO', 'MODERADO', 'INTERMEDIO', 'PRINCIPIANTE']);
            $table->enum("nivel", ['ALTO', 'MEDIO', 'BAJO']);
            $table->enum("estado", ['ACTIVO', 'INACTIVO']);
            $table->string("foto", 255)->nullable();
            $table->date("fecha_registro");
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
        Schema::dropIfExists('personals');
    }
}
