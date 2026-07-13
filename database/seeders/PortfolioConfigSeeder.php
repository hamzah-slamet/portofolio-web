<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PortfolioConfigSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    // database/seeders/PortfolioConfigSeeder.php
public function run(): void
{
    $user = \App\Models\User::first(); // user yang sudah ada

    \App\Models\PortfolioConfig::updateOrCreate(
        ['user_id' => $user->id],
        [
            'hero_title'        => "Building Modern\nWeb Applications\nWith Laravel",
            'hero_subtitle'     => "Hi, I'm {$user->name} — a passionate web developer.",
            'hero_badge_text'   => 'Working for your success',
            'hero_cta_primary'  => 'Get Started',
            'hero_cta_secondary'=> 'View Projects',

            // About
            'about_meta'        => 'MORE ABOUT ME',
            'about_title'       => 'Passionate Developer & Problem Solver',
            'about_description' => "I'm a full-stack web developer focused on building clean, scalable, and user-friendly web applications using Laravel, Vue.js, and modern frontend technologies.",
            'about_features'    => [
                'Laravel & PHP Expert', 'Vue.js & React', 'RESTful API Design',
                'MySQL & PostgreSQL', 'UI/UX Principles', 'Agile & Git Workflow',
            ],
            'profile_position'  => 'Web Developer',

            // Contact
            'contact_location'  => 'Jakarta, Indonesia',
            'contact_phone'     => '+62 812 3456 7890',
            'contact_email'     => $user->email,

            'stat_awards'       => 3,
            'stat_projects'     => 20,
            'stat_years'        => 2,
            'stat_certificates' => 10,
            // semua section aktif
            'show_hero'         => true,
            'show_about'        => true,
            'show_skills'       => true,
            'show_educations'   => true,
            'show_experiences'  => true,
            'show_certificates' => true,
            'show_projects'     => true,
            'show_contact'      => true,
            // publish!
            'is_published'      => true,
        ]
    );
}
}
