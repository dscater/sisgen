<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateValoracionPuestosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('valoracion_puestos', function (Blueprint $table) {
            $table->id();
            $table->integer("cant_min_per_alto");
            $table->integer("cant_max_per_alto");
            $table->integer("cant_min_sup_alto");
            $table->integer("cant_min_guar_alto");
            $table->integer("cant_max_guar_alto");
            $table->integer("cant_min_per_medio");
            $table->integer("cant_max_per_medio");
            $table->integer("cant_min_sup_medio");
            $table->integer("cant_min_guar_medio");
            $table->integer("cant_max_guar_medio");
            $table->integer("cant_min_per_basico");
            $table->integer("cant_max_per_basico");
            $table->integer("cant_min_sup_basico");
            $table->integer("cant_min_guar_basico");
            $table->integer("cant_max_guar_basico");
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
        Schema::dropIfExists('valoracion_puestos');
    }
}
