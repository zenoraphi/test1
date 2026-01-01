<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembimbing_dudi', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pembimbing');
            $table->unsignedBigInteger('id_dudi');

            $table->timestamps();

            $table->foreign('id_pembimbing')
                ->references('id_pembimbing')
                ->on('pembimbing')
                ->onDelete('cascade');

            $table->foreign('id_dudi')
                ->references('id_dudi')
                ->on('dudi')
                ->onDelete('cascade');

            $table->unique(['id_pembimbing', 'id_dudi']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembimbing_dudi');
    }
};
