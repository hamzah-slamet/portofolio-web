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

        // Menu navbar aktif
        $menuItems = $user->menuItems()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();

        // Visibilitas section ditentukan oleh menu: section tampil
        // jika ada menu aktif yang menuju ke anchor-nya.
        $activeAnchors = $menuItems->pluck('url')->all();
        $show = fn (string $anchor) => in_array($anchor, $activeAnchors, true);

        // Statistik hero diambil dari data yang benar-benar ada
        $statProjects     = $user->projects()->count();
        $statCertificates = $user->certificates()->count();

        // Tahun pengalaman = dari tanggal mulai paling awal sampai sekarang
        $firstExpStart = $user->experiences()->min('start_date');
        $statYears = $firstExpStart
            ? max(0, (int) \Carbon\Carbon::parse($firstExpStart)->diffInYears(now()))
            : 0;

        return view('welcome', [
            'config'        => $config,
            'user'          => $user,
            'menuItems'     => $menuItems,
            'activeAnchors' => $activeAnchors,

            'statProjects'     => $statProjects,
            'statCertificates' => $statCertificates,
            'statYears'        => $statYears,

            'heroImages' => $user->heroImages()->get(),

            // Data hanya di-query jika section-nya aktif (berdasarkan menu)
            'skills' => $show('#skills')
                ? $user->skills()
                       ->orderBy('sort_order')
                       ->orderBy('category')
                       ->get()
                : collect(),

            'educations' => $show('#education')
                ? $user->educations()->latest()->get()
                : collect(),

            'experiences' => $show('#experience')
                ? $user->experiences()->latest()->get()
                : collect(),

            'projects' => $show('#projects')
                ? $user->projects()
                       ->orderByDesc('is_featured')
                       ->orderBy('sort_order')
                       ->latest()
                       ->get()
                : collect(),

            'certificates' => $show('#certificate')
                ? $user->certificates()->orderBy('sort_order')->orderByDesc('year')->get()
                : collect(),
        ]);
    }
}
