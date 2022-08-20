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
        Schema::create('documentos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contacto_id')->nullable();
            $table->string('tipo_documento', 20)->nullable();
            $table->string('referencia_doc', 30)->nullable();
            $table->string('frmato_archivo', 10)->nullable();
            $table->string('path_documento', 240)->nullable();
            $table->foreign('contacto_id')->references('id')->on('contactos')->onDelete('cascade');
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
        Schema::dropIfExists('documentos');
    }
};
