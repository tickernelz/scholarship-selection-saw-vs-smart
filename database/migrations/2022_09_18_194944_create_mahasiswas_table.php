<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\User::class);
            $table->string('nim')->unique();
            $table->string('studi');
            $table->string('fakultas');
            $table->string('angkatan');
            $table->string('semester')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);
            $table->string('ttl')->nullable();
            $table->string('telepon')->nullable();
            $table->string('ktm')->nullable();
            $table->boolean('is_verified')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('mahasiswas');
    }
};
