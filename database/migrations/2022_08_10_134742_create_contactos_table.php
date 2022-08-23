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
            $table->string('clasificacion', 20)->nullable()->default('Pendiente');
            $table->string('numero_afiliacion', 20)->nullable();
            $table->date('fecha_afiliacion')->nullable();
            $table->string('comite_base', 20)->default('');
            $table->string('comite_rol', 20)->default('');
            $table->string('defensores', 30)->default('');
            $table->string('partido_area', 30)->nullable();
            $table->string('partido_puesto', 30)->nullable();
            $table->tinyInteger('miembro_fundador')->unsigned()->default(0);
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
            $table->string('domicilio_coordenadas', 60)->nullable();
            $table->tinyInteger('colonia_catalogada')->unsigned()->default(0);
            $table->unsignedBigInteger('colonia_id')->nullable()->default(0);
            $table->unsignedBigInteger('municipio_id')->nullable()->default(39);
            $table->unsignedBigInteger('telefono_fijo')->default(0);
            $table->unsignedBigInteger('telefono_movil')->default(0);
            $table->tinyInteger('tiene_watsapp')->unsigned()->default(0);
            $table->string('direccion_email', 80)->nullable();
            $table->tinyInteger('tiene_facebook')->unsigned()->default(0);
            $table->tinyInteger('tiene_instagram')->unsigned()->default(0);
            $table->tinyInteger('tiene_telegram')->unsigned()->default(0);
            $table->tinyInteger('tiene_twitter')->unsigned()->default(0);
            $table->tinyInteger('tiene_otra_red')->unsigned()->default(0);
            $table->string('contacto_facebook', 60)->nullable();
            $table->string('contacto_instagram', 60)->nullable();
            $table->string('contacto_telegram', 60)->nullable();
            $table->string('contacto_twitter', 60)->nullable();
            $table->string('contacto_otra_red', 60)->nullable();
            $table->date('fecha_nacimiento')->nullable();
            $table->string('dato_de_la_curp', 20)->nullable();
            $table->string('clave_elector', 20)->nullable();
            $table->string('num_credencial_ine', 20)->nullable();
            $table->string('numero_ocr_ine', 20)->nullable();
            $table->date('vigencia_credencial')->nullable();
            $table->integer('distrito_fed')->unsigned()->default(0);
            $table->integer('distrito_local')->unsigned()->default(0);
            $table->integer('numero_de_ruta')->unsigned()->default(0);
            $table->integer('numero_seccion')->unsigned()->default(0);
            $table->tinyInteger('seccion_prioritaria')->unsigned()->default(0);
            $table->string('anotaciones', 120)->nullable();
            $table->unsignedBigInteger('user_id')->default(1);
            $table->foreign('owner_id')->references('id')->on('owners')->onDelete('cascade');
            $table->foreign('categoria_id')->references('id')->on('categorias')->onDelete('cascade');
            $table->foreign('colonia_id')->references('id')->on('colonias')->onDelete('cascade');
            $table->foreign('municipio_id')->references('id')->on('municipios')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
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
