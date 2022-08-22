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
            $table->unsignedBigInteger('contacto_id')->nullable()->default(0);
            $table->string('tipo_documento', 20)->nullable()->default('');
            $table->string('referencia_doc', 30)->nullable()->default('');
            $table->string('frmato_archivo', 10)->nullable()->default('');
            $table->string('path_documento', 240)->nullable()->default('');
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
