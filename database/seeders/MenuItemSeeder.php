<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use App\Models\User;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::first();
        if (! $user) {
            return;
        }

        $defaults = [
            ['label' => 'Beranda',    'url' => '#hero'],
            ['label' => 'Tentang',    'url' => '#about'],
            ['label' => 'Keahlian',   'url' => '#skills'],
            ['label' => 'Pengalaman', 'url' => '#experience'],
            ['label' => 'Pendidikan', 'url' => '#education'],
            ['label' => 'Sertifikat', 'url' => '#certificate'],
            ['label' => 'Proyek',     'url' => '#projects'],
            ['label' => 'Kontak',     'url' => '#contact'],
        ];

        foreach ($defaults as $i => $item) {
            MenuItem::updateOrCreate(
                ['user_id' => $user->id, 'url' => $item['url']],
                ['label' => $item['label'], 'is_active' => true, 'sort_order' => $i + 1],
            );
        }
    }
}
