<?php

namespace App\Http\Controllers;

use App\Models\PortfolioConfig;
use Illuminate\Http\Request;

class PortfolioConfigController extends Controller
{
    /**
     * Tampilkan form pengaturan portfolio milik user yang login.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        // Pastikan config selalu ada (buat default jika belum)
        $config = PortfolioConfig::firstOrCreate(
            ['user_id' => $user->id],
            ['is_published' => true]
        );

        return view('content.settings.index', compact('config', 'user'));
    }

    /**
     * Simpan perubahan pengaturan.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $data = $request->validate([
            'hero_badge_text'    => ['nullable', 'string', 'max:255'],
            'hero_title'         => ['nullable', 'string', 'max:255'],
            'hero_subtitle'      => ['nullable', 'string', 'max:1000'],
            'hero_cta_primary'   => ['nullable', 'string', 'max:100'],
            'hero_cta_secondary' => ['nullable', 'string', 'max:100'],

            'about_meta'         => ['nullable', 'string', 'max:255'],
            'about_title'        => ['nullable', 'string', 'max:255'],
            'about_description'  => ['nullable', 'string', 'max:2000'],
            'about_features'     => ['nullable', 'string', 'max:2000'],
            'profile_position'   => ['nullable', 'string', 'max:255'],

            'contact_location'   => ['nullable', 'string', 'max:255'],
            'contact_phone'      => ['nullable', 'string', 'max:100'],
            'contact_email'      => ['nullable', 'string', 'max:255'],

            'stat_awards'        => ['nullable', 'integer', 'min:0', 'max:255'],
            'stat_projects'      => ['nullable', 'integer', 'min:0', 'max:255'],
            'stat_years'         => ['nullable', 'integer', 'min:0', 'max:255'],
            'stat_certificates'  => ['nullable', 'integer', 'min:0', 'max:255'],
        ]);

        // Ubah textarea fitur (satu baris = satu item) menjadi array
        $data['about_features'] = collect(preg_split('/\r\n|\r|\n/', $request->input('about_features', '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        // Kolom stat NOT NULL: field kosong -> 0
        foreach (['stat_awards', 'stat_projects', 'stat_years', 'stat_certificates'] as $stat) {
            $data[$stat] = $data[$stat] ?? 0;
        }

        // Checkbox toggle section (tidak dikirim = false)
        foreach ([
            'show_hero', 'show_about', 'show_skills', 'show_educations',
            'show_experiences', 'show_certificates', 'show_projects', 'show_contact',
            'is_published',
        ] as $flag) {
            $data[$flag] = $request->boolean($flag);
        }

        PortfolioConfig::updateOrCreate(['user_id' => $user->id], $data);

        return back()->with('success', 'Pengaturan portfolio berhasil disimpan.');
    }
}
