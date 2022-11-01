<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValoracionPersonalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valoracion_personals', function (Blueprint $table) {
            $table->id();
            $table->integer("cant_min_experto");
            $table->integer("cant_max_experto");
            $table->integer("cant_min_moderado");
            $table->integer("cant_max_moderado");
            $table->integer("cant_min_intermedio");
            $table->integer("cant_max_intermedio");
            $table->integer("cant_min_principiante");
            $table->integer("cant_max_principiante");
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
        Schema::dropIfExists('valoracion_personals');
    }
}
