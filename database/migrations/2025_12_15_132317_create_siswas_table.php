<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('siswa', function (Blueprint $table) {
            $table->id('id_siswa');
            $table->string('nama');
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['L', 'P']);

            $table->unsignedBigInteger('id_jurusan')->nullable();
            $table->unsignedBigInteger('id_pembimbing');
            $table->unsignedBigInteger('id_dudi');

            $table->string('kelas');
            $table->string('kendaraan')->nullable();

            $table->timestamps();

            $table->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusan')
                ->onDelete('set null');

            $table->foreign('id_pembimbing')
                ->references('id_pembimbing')
                ->on('pembimbing')
                ->onDelete('restrict');

            $table->foreign('id_dudi')
                ->references('id_dudi')
                ->on('dudi')
                ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
