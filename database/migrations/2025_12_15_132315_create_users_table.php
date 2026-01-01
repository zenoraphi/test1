<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            // Login identifier
            $table->string('username')->nullable()->unique();
            $table->string('nis')->nullable()->unique();

            // Basic info
            $table->string('name');
            $table->string('password');

            // Role user
            $table->enum('role', [
                'super_admin',
                'admin_jurusan',
                'siswa'
            ]);

            // Relasi jurusan (khusus admin pkl)
            $table->unsignedBigInteger('jurusan_id')->nullable();

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('jurusan_id')
                ->references('id_jurusan')
                ->on('jurusan')
                ->nullOnDelete();
        });

        // Seed Super Admin
        DB::table('users')->insert([
            'username'   => 'superadmin',
            'nis'        => null,
            'name'       => 'Super Admin',
            'password'   => Hash::make('password123'),
            'role'       => 'super_admin',
            'jurusan_id' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
