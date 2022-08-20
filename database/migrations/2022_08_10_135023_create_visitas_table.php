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
        Schema::create('visitas', function (Blueprint $table) {
            $table->id();
            $table->string('quien_recibe', 20)->nullable();
            $table->date('fecha_visita')->nullable();
            $table->time('hora_visita')->nullable();
            $table->string('tipo_visita', 20)->default('');
            $table->tinyInteger('contacto_catalogado')->unsigned()->default(0);
            $table->unsignedBigInteger('contacto_id')->nullable();
            $table->string('visitante_nombre', 40)->nullable();
            $table->unsignedBigInteger('visitante_tel_fijo')->default(0);
            $table->unsignedBigInteger('visitante_tel_movil')->default(0);
            $table->tinyInteger('visitante_watsapp')->unsigned()->default(0);
            $table->string('visitante_domicilio', 60)->nullable();
            $table->string('visitante_colonia', 60)->nullable();
            $table->string('visitante_municipio', 40)->nullable();
            $table->string('dato_num_seccion', 20)->nullable();
            $table->string('dato_del_comite', 20)->nullable();
            $table->string('dato_de_defensa', 20)->nullable();
            $table->tinyInteger('participar_comite')->unsigned()->default(0);
            $table->tinyInteger('participar_defensa')->unsigned()->default(0);
            $table->tinyInteger('invitar_capacitacion')->unsigned()->default(0);
            $table->tinyInteger('invitar_a_reuniones')->unsigned()->default(0);
            $table->string('referencia_visita', 40)->nullable();
            $table->text('asunto_visita')->nullable();
            $table->string('quien_atiende', 40)->nullable();
            $table->string('estatus_visita', 20)->default('REGISTRADA');
            $table->string('palabras_clave', 40)->nullable();
            $table->text('observaciones')->nullable();
            $table->tinyInteger('con_nueva_cita')->unsigned()->default(0);
            $table->unsignedBigInteger('owner_id')->nullable();
            $table->date('fecha_prox_cita')->nullable();
            $table->time('hora_prox_cita')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('visitas');
    }
};
