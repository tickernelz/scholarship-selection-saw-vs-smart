<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('berkas', function (Blueprint $table) {
            $table->id();
            $table->integer('mahasiswa_id')->unsigned();
            $table->foreign('mahasiswa_id')->references('id')->on('mahasiswas')->cascadeOnDelete();
            $table->integer('kriteria_id')->unsigned();
            $table->foreign('kriteria_id')->references('id')->on('kriteria')->cascadeOnDelete();
            $table->integer('tahun_akademik_id')->unsigned();
            $table->foreign('tahun_akademik_id')->references('id')->on('tahun_akademiks')->cascadeOnDelete();
            $table->string('file')->nullable();
            $table->timestamps();
            $table->archivedAt(); // Macro
        });
    }

    public function down()
    {
        Schema::dropIfExists('berkas');
    }
};
