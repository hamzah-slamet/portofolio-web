<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('portfolio_configs', function (Blueprint $table) {
            // About section
            $table->string('about_meta')->nullable()->after('hero_cta_secondary');
            $table->string('about_title')->nullable()->after('about_meta');
            $table->text('about_description')->nullable()->after('about_title');
            $table->json('about_features')->nullable()->after('about_description');
            $table->string('profile_position')->nullable()->after('about_features');

            // Contact section
            $table->string('contact_location')->nullable()->after('profile_position');
            $table->string('contact_phone')->nullable()->after('contact_location');
            $table->string('contact_email')->nullable()->after('contact_phone');
        });
    }

    public function down(): void
    {
        Schema::table('portfolio_configs', function (Blueprint $table) {
            $table->dropColumn([
                'about_meta', 'about_title', 'about_description', 'about_features',
                'profile_position', 'contact_location', 'contact_phone', 'contact_email',
            ]);
        });
    }
};
