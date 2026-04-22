@extends('welcome')


@section('title')
   {{ $post->title }}
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
    @vite(['resources/js/pages/blog-show.js', 'resources/css/pages/blog-show.css' ])    
@endpush