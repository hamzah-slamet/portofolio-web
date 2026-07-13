@extends('layouts.home')

@section('content')
    {{-- Visibilitas tiap section ditentukan oleh menu navbar (tabel menu_items). --}}
    @if(in_array('#hero', $activeAnchors))
        @include('sections.hero')
    @endif

    @if(in_array('#about', $activeAnchors))
        @include('sections.about')
    @endif

    @if(in_array('#skills', $activeAnchors))
        @include('sections.skills')
    @endif

    @if(in_array('#experience', $activeAnchors))
        @include('sections.experiences')
    @endif

    @if(in_array('#education', $activeAnchors))
        @include('sections.educations')
    @endif

    @if(in_array('#certificate', $activeAnchors))
        @include('sections.certificate')
    @endif

    @if(in_array('#projects', $activeAnchors))
        @include('sections.projects')
    @endif

    @if(in_array('#contact', $activeAnchors))
        @include('sections.contact')
    @endif
@endsection
