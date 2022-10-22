<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->string('nim')->unique();
            $table->string('studi');
            $table->string('fakultas');
            $table->string('angkatan');
            $table->string('semester')->nullable();
            $table->float('ukt')->nullable();
            $table->float('ukt_penurunan')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('ttl')->nullable();
            $table->string('telepon')->nullable();
            $table->string('ktm')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->boolean('is_beasiswa_send')->default(false);
            $table->boolean('is_beasiswa_approved')->default(false);
            $table->boolean('is_beasiswa_declined')->default(false);
            $table->timestamps();
            $table->archivedAt(); // Macro
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
};
