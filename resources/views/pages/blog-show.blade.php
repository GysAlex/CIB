@extends('welcome')

@section('seo')
    <meta name="description" content="{{ Str::limit(strip_tags($post->content), 160) }}">

    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $post->title }}">
    <meta property="og:description" content="{{ Str::limit(strip_tags($post->content), 160) }}">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    <meta property="og:image" content="{{ $post->getFirstMediaUrl('blog_posts') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $post->title }}">
    <meta name="twitter:image" content="{{ $post->getFirstMediaUrl('blog_posts') }}">
@endsection

@section('title')
    {{ $post->title }} | Actualités & Conseils en Construction au Cameroun
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')

    @include('components.blog-show.container')

    @include('components.project.cta')

    @include('components.home.footer')

@endsection

@push('scripts')
    @vite(['resources/js/pages/blog-show.js', 'resources/css/pages/blog-show.css'])
@endpush