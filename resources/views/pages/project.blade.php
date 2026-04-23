@extends('welcome')

@section('seo')
    
    <meta name="description" content="Explorez le portfolio de CIB Construction : villas modernes, bâtiments commerciaux et rénovations d'envergure au Cameroun. Découvrez notre expertise à travers nos projets finis.">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="Portfolio CIB Construction : De l'idée à la réalité">
    <meta property="og:description" content="Découvrez nos derniers chantiers et projets architecturaux réalisés avec passion et précision au Cameroun.">
    <meta property="og:url" content="{{ request()->fullUrl() }}">


    <meta property="og:image" content="{{ asset('images/og-projects-grid.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Nos projets de construction - CIB Construction">
    <meta name="twitter:image" content="{{ asset('images/og-projects-grid.jpg') }}">
    
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('title')
    Nos Réalisations & Projets BTP | CIB Construction Cameroun
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')
    @include('components.project.hero')
    @include('components.project.recent')
    @include('components.project.featured3d')
    @include('components.project.team')
    @include('components.project.cta')
    @include('components.home.footer')
@endsection


@push('scripts')
    @vite(['resources/js/pages/project.js', 'resources/css/pages/project.css' ])   
    <script type="module" src="https://ajax.googleapis.com/ajax/libs/model-viewer/3.4.0/model-viewer.min.js"></script> 
@endpush

