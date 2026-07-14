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
        @include('sections.wave', ['variant' => 1, 'bg' => '#ffffff', 'fill' => '#f3f9ff'])
        @include('sections.experiences')
        @include('sections.wave', ['variant' => 2, 'bg' => '#f3f9ff', 'fill' => '#ffffff', 'flip' => true])
    @endif

    @if(in_array('#education', $activeAnchors))
        @include('sections.educations')
    @endif

    @if(in_array('#certificate', $activeAnchors))
        @include('sections.certificate')
    @endif

    @if(in_array('#projects', $activeAnchors))
        @include('sections.wave', ['variant' => 3, 'bg' => '#ffffff', 'fill' => '#f3f9ff'])
        @include('sections.projects')
        @include('sections.wave', ['variant' => 1, 'bg' => '#f3f9ff', 'fill' => '#ffffff', 'flip' => true])
    @endif

    @if(in_array('#contact', $activeAnchors))
        @include('sections.contact')
    @endif
@endsection
