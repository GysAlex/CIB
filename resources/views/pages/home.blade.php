@extends('welcome')

@section('seo')


    <meta name="description"
        content="CIB Construction accompagne vos projets immobiliers au Cameroun : de la conception 3D à la réalisation. Expertise en gros œuvre, rénovation et construction intelligente.">

    <meta property="og:type" content="website">
    <meta property="og:title" content="Bâtissons ensemble l'excellence architecturale au Cameroun">
    <meta property="og:description"
        content="Découvrez nos réalisations et notre expertise technique pour des projets de construction durables et innovants.">
    <meta property="og:url" content="{{ url('/') }}">
    
    <meta property="og:image" content="{{ asset('images/og-home-cover.jpg') }}">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="CIB Construction - L'innovation au service du bâtiment">
    <meta name="twitter:description" content="Expertise BTP, Maçonnerie, Second œuvre et Design au Cameroun.">
    <meta name="twitter:image" content="{{ asset('images/og-home-cover.jpg') }}">

    {{-- JSON-LD : Données structurées pour Google (Local Business) --}}
    <script type="application/ld+json">
        @verbatim          
        {
          "@context": "https://schema.org",
          "@type": "LocalBusiness",
          "name": "CIB Construction",
          "image": "{{ asset('images/logo.png') }}",
          "@id": "{{ url('/') }}",
          "url": "{{ url('/') }}",
          "telephone": "+237XXXXXXXXX",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "Votre Adresse",
            "addressLocality": "Douala",
            "addressCountry": "CM"
          },
          "openingHoursSpecification": {
            "@type": "OpeningHoursSpecification",
            "dayOfWeek": [
              "Monday",
              "Tuesday",
              "Wednesday",
              "Thursday",
              "Friday"
            ],
            "opens": "08:00",
            "closes": "18:00"
          }
        }
        @endverbatim

        </script>
@endsection

@section('title')
    CIB Construction | Expert en Bâtiment et Travaux Publics au Cameroun
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
    @vite(['resources/js/pages/home.js', 'resources/css/pages/home.css'])
@endpush