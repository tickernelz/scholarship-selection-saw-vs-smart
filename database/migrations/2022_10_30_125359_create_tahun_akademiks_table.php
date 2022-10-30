<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tahun_akademiks', function (Blueprint $table) {
            $table->id();
            $table->integer('tahun_awal');
            $table->integer('tahun_akhir');
            $table->integer('is_active')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tahun_akademiks');
    }
};
