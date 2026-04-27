@extends('welcome')

@section('seo')
    <meta name="description" content="Découvrez les formations gratuites de CIB Construction. Apprenez les techniques du bâtiment, la réglementation foncière et la gestion de chantier au Cameroun avec nos experts.">

    {{-- Open Graph / Facebook / LinkedIn --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Académie CIB Construction | Formations & Expertise BTP">
    <meta property="og:description" content="Montez en compétence avec nos tutoriels vidéo. Tout savoir sur la construction durable et sécurisée au Cameroun.">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    {{-- On utilise généralement une image de couverture qui représente l'équipe ou un chantier emblématique --}}
    <meta property="og:image" content="{{ asset('images/og-formations.jpg') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Académie CIB Construction | Formations BTP">
    <meta name="twitter:description" content="Apprenez à construire demain avec les experts de CIB Construction au Cameroun.">
    <meta name="twitter:image" content="{{ asset('images/og-formations.jpg') }}">
@endsection

@section('title')
    Formations Vidéo & Expertise BTP
@endsection

@section('header')
    @include('components.project.header2')
    @include('components.formation.hero')
    @livewire('course-list')
    @include('components.home.footer')
@endsection

@section('section')

@endsection

@push('scripts')
    @vite(['resources/js/pages/formation.js', 'resources/css/pages/formation.css' ])    
@endpush