<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CvController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('content.cv.cv', compact('user'));
    }

    public function download()
    {
        $user = Auth::user();
        $pdf = Pdf::loadView('content.cv.cv-pdf', compact('user'))
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
