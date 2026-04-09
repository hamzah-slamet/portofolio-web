<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user')->after('user_id');           // admin, user, dll
            $table->string('tempat_lahir')->nullable()->after('umur');
            $table->date('tanggal_lahir')->nullable()->after('tempat_lahir');
            $table->string('jenis_kelamin')->nullable()->after('tanggal_lahir'); // Laki-laki / Perempuan
            $table->string('agama')->nullable()->after('jenis_kelamin');
            $table->string('kewarganegaraan')->default('Indonesia')->after('agama');
            $table->string('status_pernikahan')->nullable()->after('kewarganegaraan'); // Belum Menikah, Menikah, dll
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'role',
                'tempat_lahir',
                'tanggal_lahir',
                'jenis_kelamin',
                'agama',
                'kewarganegaraan',
                'status_pernikahan',
            ]);
        });
    }
};
