<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $query = Project::owned()->latest();

        if ($request->filled('tech')) {
            $query->whereJsonContains('tech_stack', $request->tech);
        }
        if ($request->filter === 'featured') {
            $query->featured();
        }
        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->q . '%');
        }

       $projects = $query->paginate(5)->withQueryString();

        $stats = [
            'total'       => Project::owned()->count(),
            'featured'    => Project::owned()->featured()->count(),
            'online'      => Project::owned()->online()->count(),
            'open_source' => Project::owned()->whereNotNull('github_url')->count(),
        ];

        $techTags = Project::owned()
            ->pluck('tech_stack')
            ->flatten()
            ->unique()
            ->sort()
            ->values();

        return view('content.projects.project', compact('projects', 'stats', 'techTags'));
    }

    public function create()
    {
        return view('content.projects.create');
    }

    public function store(ProjectRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        Project::create($data);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan!');
    }

    public function show(Project $project)
    {
        $this->authorizeOwner($project);
        return view('content.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorizeOwner($project);
        return view('content.projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorizeOwner($project);

        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($data);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui!');
    }

    public function destroy(Project $project)
    {
        $this->authorizeOwner($project);

        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus!');
    }

    public function toggleFeatured(Project $project)
    {
        $this->authorizeOwner($project);
        $project->update(['is_featured' => ! $project->is_featured]);

        return response()->json([
            'is_featured' => $project->is_featured,
            'message'     => $project->is_featured ? 'Ditandai sebagai Featured' : 'Featured dinonaktifkan',
        ]);
    }

    private function authorizeOwner(Project $project): void
    {
        abort_if($project->user_id !== auth()->id(), 403, 'Akses ditolak.');
    }
}
