<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->string('degree');             // S1, S2, SMA, Bootcamp, dll.
            $table->string('major');              // Jurusan / Program Studi
            $table->string('institution');        // Nama institusi
            $table->string('institution_type')->default('university'); // university | school | bootcamp | course
            $table->string('location')->nullable();
            $table->text('description')->nullable();
            $table->decimal('gpa', 3, 2)->nullable();  // 3.85

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('is_current')->default(false);

            $table->json('achievements')->nullable(); // ['Cumlaude','Beasiswa XYZ',...]
            $table->integer('sort_order')->default(0);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
