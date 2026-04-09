<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_id')->unique()->nullable()->after('id'); // contoh: USR-001
            $table->integer('umur')->nullable()->after('email');
            $table->text('alamat')->nullable()->after('umur');
            $table->string('foto_profil')->nullable()->after('alamat'); // simpan path
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_id', 'umur', 'alamat', 'foto_profil']);
        });
    }
};
