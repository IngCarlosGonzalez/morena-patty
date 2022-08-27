<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribers', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_full', 60)->nullable();
            $table->unsignedBigInteger('telefono_movil')->default(0);
            $table->tinyInteger('tiene_watsapp')->unsigned()->default(0);
            $table->string('colonia_o_sector', 40)->nullable();
            $table->string('localidad_municipio', 50)->nullable();
            $table->string('entidad_federativa', 30)->nullable();
            $table->string('correo_electronico', 60)->nullable();
            $table->string('texto_del_mensaje', 240)->nullable();
            $table->string('observaciones', 40)->nullable();
            $table->tinyInteger('paso_a_contacto')->unsigned()->default(0);
            $table->unsignedBigInteger('contacto_id')->default(0);
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
        Schema::dropIfExists('subscribers');
    }
};
