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
            ['label' => 'Home',        'url' => '#hero'],
            ['label' => 'About',       'url' => '#about'],
            ['label' => 'Skills',      'url' => '#skills'],
            ['label' => 'Experience',  'url' => '#experience'],
            ['label' => 'Education',   'url' => '#education'],
            ['label' => 'Certificate', 'url' => '#certificate'],
            ['label' => 'Project',     'url' => '#projects'],
            ['label' => 'Contact',     'url' => '#contact'],
        ];

        foreach ($defaults as $i => $item) {
            MenuItem::updateOrCreate(
                ['user_id' => $user->id, 'url' => $item['url']],
                ['label' => $item['label'], 'is_active' => true, 'sort_order' => $i + 1],
            );
        }
    }
}
