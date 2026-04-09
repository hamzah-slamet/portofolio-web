<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->text('tentang')->nullable()->after('alamat');
            $table->enum('status_akun', ['aktif', 'nonaktif'])->default('aktif')->after('tentang');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['tentang', 'status_akun']);
        });
    }
};
