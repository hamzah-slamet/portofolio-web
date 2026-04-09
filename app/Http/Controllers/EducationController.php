<?php

namespace App\Http\Controllers;

use App\Models\Education;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EducationController extends Controller
{
    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $educations = Education::forUser(Auth::id())
            ->ordered()
            ->get();

        $total       = $educations->count();
        $activeCount = $educations->where('is_current', true)->count();
        $current     = $educations->firstWhere('is_current', true);
        $oldest      = $educations->sortBy('start_date')->first();
        $latest      = $educations->sortByDesc('start_date')->first();

        // Hitung total tahun pendidikan
        $totalMonths = $educations->sum(function ($e) {
            $start = $e->start_date;
            $end   = $e->is_current ? now() : ($e->end_date ?? now());
            return $start->diffInMonths($end);
        });
        $totalYears    = intdiv($totalMonths, 12);
        $totalMonRem   = $totalMonths % 12;
        $totalDuration = ($totalYears ? "{$totalYears} thn " : '')
                       . ($totalMonRem ? "{$totalMonRem} bln" : '');

        return view('content.educations.index', compact(
            'educations',
            'total',
            'activeCount',
            'totalDuration',
            'current',
            'oldest',
            'latest',
        ));
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('content.educations.form', [
            'education' => null,
            'isEdit'    => false,
        ]);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $data = $request->validate([
            'degree'           => 'required|string|max:100',
            'major'            => 'required|string|max:100',
            'institution'      => 'required|string|max:150',
            'institution_type' => 'nullable|string|max:50',
            'location'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'gpa'              => 'nullable|numeric|min:0|max:4',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'is_current'       => 'boolean',
            'achievements'     => 'nullable|string',
        ]);

        $data['user_id']    = Auth::id();
        $data['is_current'] = $request->boolean('is_current');
        $data['achievements'] = $this->parseList($request->input('achievements'));

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        Education::create($data);

        return redirect()->route('educations.index')
            ->with('success', 'Pendidikan berhasil ditambahkan.');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(Education $education)
    {
        $this->authorizeOwner($education);

        return view('content.educations.form', [
            'education' => $education,
            'isEdit'    => true,
        ]);
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(Request $request, Education $education)
    {
        $this->authorizeOwner($education);

        $data = $request->validate([
            'degree'           => 'required|string|max:100',
            'major'            => 'required|string|max:100',
            'institution'      => 'required|string|max:150',
            'institution_type' => 'nullable|string|max:50',
            'location'         => 'nullable|string|max:100',
            'description'      => 'nullable|string',
            'gpa'              => 'nullable|numeric|min:0|max:4',
            'start_date'       => 'required|date',
            'end_date'         => 'nullable|date|after_or_equal:start_date',
            'is_current'       => 'boolean',
            'achievements'     => 'nullable|string',
        ]);

        $data['is_current']   = $request->boolean('is_current');
        $data['achievements'] = $this->parseList($request->input('achievements'));

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $education->update($data);

        return redirect()->route('educations.index')
            ->with('success', 'Pendidikan berhasil diperbarui.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    public function destroy(Education $education)
    {
        $this->authorizeOwner($education);
        $education->delete();

        return redirect()->route('educations.index')
            ->with('success', 'Pendidikan berhasil dihapus.');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function authorizeOwner(Education $education): void
    {
        abort_if($education->user_id !== Auth::id(), 403);
    }

    /** "Cumlaude, Beasiswa XYZ" → ['Cumlaude','Beasiswa XYZ'] */
    private function parseList(?string $raw): array
    {
        if (!$raw) return [];
        return array_values(array_filter(
            array_map('trim', explode(',', $raw))
        ));
    }
}
