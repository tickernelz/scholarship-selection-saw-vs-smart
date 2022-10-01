<?php

use App\Models\Kriteria;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('subkriteria', function (Blueprint $table) {
            $table->id();
            $table->integer('kriteria_id')->unsigned();
            $table->foreign('kriteria_id')->references('id')->on('kriteria')->cascadeOnDelete();
            $table->string('nama');
            $table->integer('prioritas');
            $table->float('bobot')->nullable();
            $table->unique(['prioritas', 'kriteria_id'], 'subkriteria_kriteria_id_prioritas_unique');
        });
    }

    public function down()
    {
        Schema::enableForeignKeyConstraints();
        Schema::table('subkriteria', function (Blueprint $table) {
            $table->dropForeign(['kriteria_id']);
            $table->dropUnique('subkriteria_kriteria_id_prioritas_unique');
        });
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('subkriteria');
    }
};
