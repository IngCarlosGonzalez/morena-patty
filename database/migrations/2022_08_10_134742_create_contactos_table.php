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
        Schema::create('contactos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('owner_id');
            $table->tinyInteger('esta_vigente')->unsigned()->default(1);
            $table->string('clave_tipo', 20)->default('SinTipo');
            $table->string('clave_origen', 20)->default('SinOrigen');
            $table->unsignedBigInteger('categoria_id')->default(1);
            $table->string('clasificacion', 20)->nullable();
            $table->string('comite_base', 20)->default('');
            $table->string('comite_rol', 20)->default('');
            $table->string('defensores', 30)->default('');
            $table->string('partido_area', 30)->nullable();
            $table->string('partido_puesto', 30)->nullable();
            $table->string('titulo_cargo', 30)->nullable();
            $table->string('gestor_titulo', 30)->nullable();
            $table->string('razon_social', 30)->nullable();
            $table->string('nombre_full', 60)->nullable();
            $table->string('ap_paterno', 30)->nullable();
            $table->string('ap_materno', 30)->nullable();
            $table->string('nombre_uno', 30)->nullable();
            $table->string('nombre_dos', 30)->nullable();
            $table->string('localidad_mpio', 60)->nullable();
            $table->string('domicilio_full', 90)->nullable();
            $table->string('domicilio_calle', 60)->nullable();
            $table->string('domicilio_numext', 10)->nullable();
            $table->string('domicilio_numint', 10)->nullable();
            $table->string('domicilio_colonia', 60)->nullable();
            $table->integer('domicilio_codpost')->unsigned()->default(0);
            $table->tinyInteger('colonia_catalogada')->unsigned()->default(0);
            $table->unsignedBigInteger('colonia_id')->nullable();
            $table->unsignedBigInteger('telefono_fijo')->default(0);
            $table->unsignedBigInteger('telefono_movil')->default(0);
            $table->tinyInteger('tiene_watsapp')->unsigned()->default(0);
            $table->string('direccion_email', 80)->nullable();
            $table->string('redes_sociales', 80)->nullable();
            $table->string('contactos_redes', 120)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('clave_curp', 20)->nullable();
            $table->string('clave_elector', 20)->nullable();
            $table->string('credencial_ine', 20)->nullable();
            $table->string('numero_de_ine', 20)->nullable();
            $table->date('vigencia_creden')->nullable();
            $table->integer('distrito_fed')->unsigned()->default(0);
            $table->integer('distrito_local')->unsigned()->default(0);
            $table->integer('numero_de_ruta')->unsigned()->default(0);
            $table->integer('numero_seccion')->unsigned()->default(0);
            $table->unsignedBigInteger('user_id');
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('colonia_id')->references('id')->on('colonias')->onDelete('cascade');
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
        Schema::dropIfExists('contactos');
    }
};
