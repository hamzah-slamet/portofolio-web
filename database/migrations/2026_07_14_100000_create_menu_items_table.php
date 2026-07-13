<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('menu_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('label');                       // teks menu, mis: "Home"
            $table->string('url');                         // tujuan, mis: "#hero" atau "https://..."
            $table->boolean('is_active')->default(true);   // tampil / sembunyi
            $table->integer('sort_order')->default(0);     // urutan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('menu_items');
    }
};
