<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dudi', function (Blueprint $table) {
            $table->id('id_dudi');

            $table->string('nama');
            $table->text('alamat');

            // pihak DUDI
            $table->string('pimpinan')->nullable();
            $table->string('pembimbing_dudi');
            $table->string('jabatan')->nullable();

            // kapasitas
            $table->integer('daya_tampung')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dudi');
    }
};
