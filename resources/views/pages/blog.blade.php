@extends('welcome')


@section('title')
    Blog
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')
    @include('components.blog.hero')
    @livewire('post-list')
@endsection

@push('scripts')
    @vite(['resources/js/pages/blog.js', 'resources/css/pages/blog.css' ])    
@endpush