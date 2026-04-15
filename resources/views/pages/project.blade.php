@extends('welcome')

@section('title')
    Projets
@endsection

@section('header')
    @include('components.home.header2')
@endsection

@section('section')
    @include('components.project.hero')
    @include('components.project.recent')
@endsection


@push('scripts')
    @vite(['resources/js/pages/project.js', 'resources/css/pages/project.css' ])    
@endpush

