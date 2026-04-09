<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Experience;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            // Stat cards
            'totalProjects'        => Project::count(),
            'featuredProjects'     => Project::where('is_featured', true)->count(),
            'totalSkills'          => Skill::count(),
            'totalSkillCategories' => Skill::distinct('category')->count('category'),
            'totalExperiences'     => Experience::count(),
            'activeExperience'     => Experience::whereNull('end_date')->exists(),

            // Project list (5 terbaru)
            'recentProjects'       => Project::latest()->take(5)->get(),

            // Top skills (6 tertinggi berdasarkan proficiency)
            'topSkills' => Skill::orderByDesc('level')->take(6)->get(),

            // Semua pengalaman kerja
            'experiences'          => Experience::orderByDesc('start_date')->get(),
        ]);
    }
}
