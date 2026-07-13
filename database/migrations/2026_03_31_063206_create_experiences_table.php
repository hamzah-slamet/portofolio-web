<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('position');           // Jabatan / posisi
            $table->string('company');            // Nama perusahaan
            $table->string('company_type')->nullable(); // building / rocket / freelance, dll.
            $table->string('location')->nullable();
            $table->text('description')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();  // null = masih aktif
            $table->boolean('is_current')->default(false);

            $table->json('skills')->nullable();    // ['Laravel','Vue.js',...]
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
