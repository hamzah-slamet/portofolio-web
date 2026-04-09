@extends('layouts.app')

@section('title', 'Edit Project')
@section('topbar-title', 'Edit Project')

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">
            Edit Project
        </h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">
            <a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Projects</a>
            <i class="bi bi-chevron-right mx-1" style="font-size:.65rem;"></i> {{ $project->title }}
        </p>
    </div>
    <form action="{{ route('projects.destroy', $project) }}" method="POST"
          onsubmit="return confirm('Hapus project \'{{ addslashes($project->title) }}\'?')">
        @csrf @method('DELETE')
        <button type="submit"
                style="padding:7px 14px;font-size:.8rem;border-radius:8px;border:1.5px solid #fecaca;background:#fff1f2;color:#ef4444;cursor:pointer;font-weight:600;">
            <i class="bi bi-trash3-fill me-1"></i> Hapus Project
        </button>
    </form>
</div>
@endsection

@section('content')
@include('content.projects._form', [
    'action'  => route('projects.update', $project),
    'method'  => 'PUT',
    'project' => $project,
])
@endsection
