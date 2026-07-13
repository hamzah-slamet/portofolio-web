<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    /**
     * Kumpulkan semua data CV dari berbagai menu:
     * Profil, Skills, Pengalaman, Pendidikan, Projek.
     */
    private function cvData(User $user): array
    {
        return [
            'user'        => $user,
            'config'      => $user->portfolioConfig,
            'skills'      => $user->skills()->orderByDesc('level')->orderBy('sort_order')->get(),
            'experiences' => $user->experiences()->orderByDesc('is_current')->orderByDesc('start_date')->get(),
            'educations'  => $user->educations()->orderByDesc('is_current')->orderByDesc('start_date')->get(),
            'projects'    => $user->projects()->orderByDesc('is_featured')->orderBy('sort_order')->latest()->get(),
        ];
    }

    public function index()
    {
        return view('content.cv.cv', $this->cvData(Auth::user()));
    }

    public function download()
    {
        $user = Auth::user();

        $pdf = Pdf::loadView('content.cv.cv-pdf', $this->cvData($user))
                  ->setPaper('a4', 'portrait')
                  ->setOptions([
                      'defaultFont'          => 'sans-serif',
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled'      => true,
                      'dpi'                  => 150,
                  ]);

        return $pdf->download('CV-' . str_replace(' ', '-', $user->name) . '.pdf');
    }
}
