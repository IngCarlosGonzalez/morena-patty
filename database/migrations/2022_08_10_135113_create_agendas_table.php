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
        Schema::create('agendas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->date('fecha_de_cita')->nullable();
            $table->time('hora_de_cita')->nullable();
            $table->string('tipo_de_cita', 20)->default('');
            $table->string('origen_de_cita', 20)->default('');
            $table->string('clase_de_cita', 20)->default('');
            $table->string('prioridad_cita', 20)->default('');
            $table->tinyInteger('contacto_catalogado')->unsigned()->default(0);
            $table->unsignedBigInteger('contacto_id')->nullable();
            $table->string('persona_nombre', 60)->nullable();
            $table->string('persona_telefonos', 60)->nullable();
            $table->string('referencia_cita', 60)->nullable();
            $table->tinyInteger('cita_confirmada')->unsigned()->default(0);
            $table->string('confirma_notas', 30)->nullable();
            $table->tinyInteger('cita_cancelada')->unsigned()->default(0);
            $table->string('cancela_notas', 30)->nullable();
            $table->tinyInteger('cita_reprogramada')->unsigned()->default(0);
            $table->string('reprograma_notas', 30)->nullable();
            $table->date('nueva_fecha')->nullable();
            $table->time('nueva_hora')->nullable();
            $table->tinyInteger('cita_efectuada')->unsigned()->default(0);
            $table->text('notas_resultado')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
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
        Schema::dropIfExists('agendas');
    }
};
