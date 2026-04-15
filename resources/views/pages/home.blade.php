@extends('welcome')


@section('title')
    Accueil
@endsection

@section('header')
    @include('components.home.header')
@endsection

@section('section')
    @include('components.home.hero')

    @include('components.home.about')

    @include('components.home.services')

    @include('components.home.why-us')

    @include('components.home.some-projects')

    @include('components.home.testimonial')

    @include('components.home.blog-news')

    @include('components.home.footer')
@endsection

@push('scripts')
    @vite(['resources/js/pages/home.js', 'resources/css/pages/home.css' ])    
@endpush