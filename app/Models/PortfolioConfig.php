<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PortfolioConfig extends Model
{
    protected $fillable = [
        'user_id',
        'hero_title', 'hero_subtitle', 'hero_badge_text',
        'hero_cta_primary', 'hero_cta_secondary',
        'stat_awards', 'stat_projects', 'stat_years', 'stat_certificates',
        'show_hero', 'show_about', 'show_skills',
        'show_educations', 'show_experiences',
        'show_certificates', 'show_projects', 'show_contact',
        'is_published',
    ];

    protected $casts = [
        'show_hero'         => 'boolean',
        'show_about'        => 'boolean',
        'show_skills'       => 'boolean',
        'show_educations'   => 'boolean',
        'show_experiences'  => 'boolean',
        'show_certificates' => 'boolean',
        'show_projects'     => 'boolean',
        'show_contact'      => 'boolean',
        'is_published'      => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
