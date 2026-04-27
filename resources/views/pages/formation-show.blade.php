@extends('welcome')

@section('seo')
    @php
        $seoDescription = $course->summary ?: Str::limit(strip_tags($course->description), 160);
        $seoImage = $course->getFirstMediaUrl('course_thumbnails') ?: 'https://img.youtube.com/vi/'.$course->youtube_id.'/maxresdefault.jpg';
    @endphp

    <meta name="description" content="{{ $seoDescription }}">

    <meta property="og:type" content="video.other"> {{-- Type spécifique pour les vidéos --}}
    <meta property="og:title" content="Formation : {{ $course->title }}">
    <meta property="og:description" content="{{ $seoDescription }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:image" content="{{ $seoImage }}">
    <meta property="og:video" content="https://www.youtube.com/embed/{{ $course->youtube_id }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Formation : {{ $course->title }}">
    <meta name="twitter:description" content="{{ $seoDescription }}">
    <meta name="twitter:image" content="{{ $seoImage }}">
    
    <meta name="video:duration" content="{{ $course->duration }}">
@endsection

@section('title')
    {{ $course->title }} | Académie CIB
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')

    @include('components.formation-show.formation-display')

    @include('components.project.cta')

    @include('components.home.footer')

@endsection

@push('scripts')
    @vite(['resources/js/pages/formation-show.js', 'resources/css/pages/formation-show.css'])
@endpush