<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::where('user_id', auth()->id())
            ->orderBy('category')
            ->orderBy('sort_order')
            ->orderBy('name')
            ->get();

        $skillsByCategory = $skills->groupBy('category');

        $stats = [
            'total'      => $skills->count(),
            'categories' => $skillsByCategory->count(),
            'highest'    => $skills->max('level') ?? 0,
            'average'    => $skills->count() ? round($skills->avg('level')) : 0,
        ];

        $categoryColors = [
            'Backend'        => '#ef4444',
            'Frontend'       => '#0ea5e9',
            'DevOps & Tools' => '#ea580c',
            'Design'         => '#db2777',
            'Mobile'         => '#8b5cf6',
            'Database'       => '#16a34a',
        ];

        $categoryStats = $skillsByCategory->map(function ($group, $name) use ($categoryColors) {
            return [
                'name'  => $name,
                'count' => $group->count(),
                'avg'   => round($group->avg('level')),
                'color' => $categoryColors[$name] ?? '#64748b',
            ];
        })->values()->toArray();

        return view('content.skills.skill', compact(
            'skills', 'skillsByCategory', 'stats', 'categoryStats'
        ));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'           => 'required|string|max:100',
            'category'       => 'required|string|max:100',
            'level'          => 'required|integer|min:0|max:100',
            'icon'           => 'nullable|string|max:100',
            'color'          => 'nullable|string|max:20',
            'certificates'   => 'nullable|array',
            'certificates.*' => 'nullable|url|max:500',
        ]);

        $data['certificates'] = collect($request->certificates ?? [])
            ->filter(fn($c) => !empty(trim($c)))
            ->values()
            ->toArray();

        $data['user_id']    = auth()->id();
        $data['color_fill'] = $this->generateFill($data['color'] ?? '#2563eb');

        Skill::create($data);

        return redirect()->route('skills.index')
            ->with('success', 'Skill berhasil ditambahkan!');
    }

    public function update(Request $request, Skill $skill)
    {
        abort_if($skill->user_id !== auth()->id(), 403);

        $data = $request->validate([
            'name'           => 'required|string|max:100',
            'category'       => 'required|string|max:100',
            'level'          => 'required|integer|min:0|max:100',
            'icon'           => 'nullable|string|max:100',
            'color'          => 'nullable|string|max:20',
            'certificates'   => 'nullable|array',
            'certificates.*' => 'nullable|url|max:500',
        ]);

        $data['certificates'] = collect($request->certificates ?? [])
            ->filter(fn($c) => !empty(trim($c)))
            ->values()
            ->toArray();

        $data['color_fill'] = $this->generateFill($data['color'] ?? '#2563eb');

        $skill->update($data);

        return redirect()->route('skills.index')
            ->with('success', 'Skill berhasil diperbarui!');
    }

    public function destroy(Skill $skill)
    {
        abort_if($skill->user_id !== auth()->id(), 403);

        $skill->delete();

        return redirect()->route('skills.index')
            ->with('success', 'Skill berhasil dihapus!');
    }

    private function generateFill(string $hex): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) !== 6) return '#eff6ff';

        $r = (int) round(hexdec(substr($hex, 0, 2)) * 0.15 + 255 * 0.85);
        $g = (int) round(hexdec(substr($hex, 2, 2)) * 0.15 + 255 * 0.85);
        $b = (int) round(hexdec(substr($hex, 4, 2)) * 0.15 + 255 * 0.85);

        return sprintf('#%02x%02x%02x', $r, $g, $b);
    }
}
