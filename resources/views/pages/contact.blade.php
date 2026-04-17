@extends('welcome')


@section('title')
    Contact
@endsection

@section('header')
    @include('components.project.header2')
@endsection

@section('section')
    @include('components.contact.hero')
    @include('components.contact.form')
    @include('components.contact.map')
    @include('components.contact.faq')
    @include('components.project.cta')
    @include('components.home.footer')
@endsection

@push('scripts')
    @vite(['resources/js/pages/contact.js', 'resources/css/pages/contact.css' ])    
@endpush