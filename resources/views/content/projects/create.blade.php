@extends('layouts.app')

@section('title', 'Tambah Project')
@section('topbar-title', 'Tambah Project')

@section('page-header')
<div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
    <div>
        <h4 class="mb-1" style="font-size:1.25rem; font-weight:800; color:var(--text-primary);">
            Tambah Project
        </h4>
        <p class="text-muted mb-0" style="font-size:.78rem;">
            <a href="{{ route('projects.index') }}" class="text-decoration-none text-muted">Projects</a>
            <i class="bi bi-chevron-right mx-1" style="font-size:.65rem;"></i> Tambah Baru
        </p>
    </div>
</div>
@endsection

@section('content')
@include('content.projects._form', [
    'action'  => route('projects.store'),
    'method'  => 'POST',
    'project' => null,
])
@endsection
