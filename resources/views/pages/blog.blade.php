@extends('welcome')

@section('seo')
    <meta name="description" content="Découvrez les conseils de nos experts sur le BIM, la réglementation immobilière au Cameroun et les innovations du bâtiment pour réussir vos projets de construction.">
    
    <meta property="og:type" content="website">
    <meta property="og:title" content="Expertise et Innovation dans le BTP au Cameroun - Le Blog">
    <meta property="og:description" content="Explorez nos guides pratiques et analyses sur l'avenir de la construction intelligente et durable.">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:image" content="{{ asset('images/og-blog-cover.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Le Mag de l'Expertise - CIB Construction">
    <meta name="twitter:description" content="Tout ce qu'il faut savoir sur l'immobilier et le BTP au Cameroun.">
    <meta name="twitter:image" content="{{ asset('images/og-blog-cover.jpg') }}">
    
    <link rel="canonical" href="{{ url()->current() }}">
@endsection

@section('title')
    Actualités & Conseils en Construction au Cameroun | Blog CIB Construction
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')
    @include('components.blog.hero')
    @livewire('post-list')
    @include('components.home.footer')
@endsection

@push('scripts')
    @vite(['resources/js/pages/blog.js', 'resources/css/pages/blog.css' ])    
@endpush