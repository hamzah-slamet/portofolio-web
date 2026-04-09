<?php

namespace App\Http\Controllers;

use App\Models\User;

class PortfolioController extends Controller
{
    public function index()
    {
        // Ambil user pertama yang portfolionya published
        // Sesuaikan jika multi-user (pakai slug/username)
        $user = User::whereHas('portfolioConfig', function ($q) {
            $q->where('is_published', true);
        })->firstOrFail();

        return $this->buildView($user);
    }

    // Untuk multi-user: /portfolio/{username}
    public function show(string $username)
    {
        $user = User::where('name', $username)
            ->whereHas('portfolioConfig', fn($q) => $q->where('is_published', true))
            ->firstOrFail();

        return $this->buildView($user);
    }

    private function buildView(User $user)
    {
        $config = $user->portfolioConfig;

        return view('welcome', [
            'config' => $config,
            'user'   => $user,

            // Data hanya di-query jika section-nya aktif
            'skills' => $config->show_skills
                ? $user->skills()
                       ->orderBy('sort_order')
                       ->orderBy('category')
                       ->get()
                : collect(),

            'educations' => $config->show_educations
                ? $user->educations()->latest()->get()
                : collect(),

            'experiences' => $config->show_experiences
                ? $user->experiences()->latest()->get()
                : collect(),

            'projects' => $config->show_projects
                ? $user->projects()
                       ->where('is_featured', true)
                       ->orderBy('sort_order')
                       ->get()
                : collect(),
        ]);
    }
}
