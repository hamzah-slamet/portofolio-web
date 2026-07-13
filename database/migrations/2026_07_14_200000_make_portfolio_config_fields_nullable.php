<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_configs', function (Blueprint $table) {
            $table->string('hero_cta_primary')->nullable()->default('Get Started')->change();
            $table->string('hero_cta_secondary')->nullable()->default('View Projects')->change();
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_configs', function (Blueprint $table) {
            $table->string('hero_cta_primary')->nullable(false)->default('Get Started')->change();
            $table->string('hero_cta_secondary')->nullable(false)->default('View Projects')->change();
        });
    }
};
