@extends('welcome')

@section('title')
    Projets
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

