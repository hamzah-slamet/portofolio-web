<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   // database/migrations/xxxx_create_portfolio_configs_table.php
public function up(): void
{
    Schema::create('portfolio_configs', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->unique()->constrained()->onDelete('cascade');
        // unique() karena one-to-one

        // ── Hero content ──────────────────────────────
        $table->string('hero_title')->nullable();
        $table->string('hero_subtitle')->nullable();
        $table->string('hero_badge_text')->nullable();
        $table->string('hero_cta_primary')->default('Get Started');
        $table->string('hero_cta_secondary')->default('View Projects');

        // ── Stats bar ─────────────────────────────────
        $table->unsignedTinyInteger('stat_awards')->default(0);
        $table->unsignedTinyInteger('stat_projects')->default(0);
        $table->unsignedTinyInteger('stat_years')->default(0);
        $table->unsignedTinyInteger('stat_certificates')->default(0);

        // ── Section visibility flags ───────────────────
        $table->boolean('show_hero')->default(true);
        $table->boolean('show_about')->default(true);
        $table->boolean('show_skills')->default(true);
        $table->boolean('show_educations')->default(true);
        $table->boolean('show_experiences')->default(true);
        $table->boolean('show_certificates')->default(true);
        $table->boolean('show_projects')->default(true);
        $table->boolean('show_contact')->default(true);

        // ── Master switch ──────────────────────────────
        $table->boolean('is_published')->default(false);

        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portfolio_configs');
    }
};
