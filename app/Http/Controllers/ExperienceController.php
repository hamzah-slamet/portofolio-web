<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    // ─── Index ────────────────────────────────────────────────────────────────

    public function index()
    {
        $experiences = Experience::forUser(Auth::id())
            ->ordered()
            ->get();

        // Stats
        $total          = $experiences->count();
        $activeCount    = $experiences->where('is_current', true)->count();
        $totalMonths    = $experiences->sum(function ($e) {
            $start = $e->start_date;
            $end   = $e->is_current ? now() : ($e->end_date ?? now());
            return $start->diffInMonths($end);
        });
        $totalYears  = intdiv($totalMonths, 12);
        $totalMonRem = $totalMonths % 12;
        $totalDuration = ($totalYears ? "{$totalYears} thn " : '') . ($totalMonRem ? "{$totalMonRem} bln" : '');

        $current = $experiences->firstWhere('is_current', true);
        $oldest  = $experiences->sortBy('start_date')->first();

        return view('content.experiences.experience', compact(
            'experiences',
            'total',
            'activeCount',
            'totalDuration',
            'current',
            'oldest',
        ));
    }

    // ─── Create ───────────────────────────────────────────────────────────────

    public function create()
    {
        return view('content.experiences.form', [
            'experience' => null,
            'isEdit'     => false,
        ]);
    }

    // ─── Store ────────────────────────────────────────────────────────────────

    public function store(Request $request)
    {
        $data = $request->validate([
            'position'     => 'required|string|max:100',
            'company'      => 'required|string|max:100',
            'company_type' => 'nullable|string|max:50',
            'location'     => 'nullable|string|max:100',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'is_current'   => 'boolean',
            'skills'       => 'nullable|string', // comma-separated dari input
        ]);

        $data['user_id']    = Auth::id();
        $data['is_current'] = $request->boolean('is_current');
        $data['skills']     = $this->parseSkills($request->input('skills'));

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        Experience::create($data);

        return redirect()->route('experiences.index')
            ->with('success', 'Experience berhasil ditambahkan.');
    }

    // ─── Edit ─────────────────────────────────────────────────────────────────

    public function edit(Experience $experience)
    {
        $this->authorizeOwner($experience);

        return view('content.experiences.form', [
            'experience' => $experience,
            'isEdit'     => true,
        ]);
    }

    // ─── Update ───────────────────────────────────────────────────────────────

    public function update(Request $request, Experience $experience)
    {
        $this->authorizeOwner($experience);

        $data = $request->validate([
            'position'     => 'required|string|max:100',
            'company'      => 'required|string|max:100',
            'company_type' => 'nullable|string|max:50',
            'location'     => 'nullable|string|max:100',
            'description'  => 'nullable|string',
            'start_date'   => 'required|date',
            'end_date'     => 'nullable|date|after_or_equal:start_date',
            'is_current'   => 'boolean',
            'skills'       => 'nullable|string',
        ]);

        $data['is_current'] = $request->boolean('is_current');
        $data['skills']     = $this->parseSkills($request->input('skills'));

        if ($data['is_current']) {
            $data['end_date'] = null;
        }

        $experience->update($data);

        return redirect()->route('experiences.index')
            ->with('success', 'Experience berhasil diperbarui.');
    }

    // ─── Destroy ──────────────────────────────────────────────────────────────

    public function destroy(Experience $experience)
    {
        $this->authorizeOwner($experience);

        $experience->delete();

        return redirect()->route('experiences.index')
            ->with('success', 'Experience berhasil dihapus.');
    }

    // ─── Helpers ──────────────────────────────────────────────────────────────

    private function authorizeOwner(Experience $experience): void
    {
        abort_if($experience->user_id !== Auth::id(), 403);
    }

    /**
     * "Laravel, Vue.js, Redis" → ['Laravel','Vue.js','Redis']
     */
    private function parseSkills(?string $raw): array
    {
        if (!$raw) return [];
        return array_values(array_filter(
            array_map('trim', explode(',', $raw))
        ));
    }
}
