@extends('welcome')

@section('seo')
    {{-- Meta Description : Doit rassurer sur la disponibilité et la réactivité --}}
    <meta name="description"
        content="Vous avez un projet de construction ou de rénovation au Cameroun ? Contactez CIB Construction pour un devis gratuit. Nos experts vous répondent sous 48h.">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="Prêt à lancer votre chantier ? Contactez-nous">
    <meta property="og:description"
        content="Discutons de votre projet immobilier. Nos bureaux à Douala vous accueillent pour donner vie à vos ambitions architecturales.">
    <meta property="og:url" content="{{ request()->fullUrl() }}">
    {{-- Une image de vos bureaux ou d'un plan architectural avec un stylo (symbole de consultation) --}}
    <meta property="og:image" content="{{ asset('images/og-contact.jpg') }}">

    {{-- Twitter Card --}}
    <meta name="twitter:card" content="summary">
    <meta name="twitter:title" content="Contact - CIB Construction">
    <meta name="twitter:description" content="Demandez votre devis personnalisé pour tout projet de bâtiment au Cameroun.">

    {{-- JSON-LD : Spécifique pour la page de contact (ContactPoint) --}}
    <script type="application/ld+json">

            @verbatim
                            {
                  "@context": "https://schema.org",
                  "@type": "Organization",
                  "url": "{{ url('/') }}",
                  "logo": "{{ asset('images/logo.png') }}",
                  "contactPoint": [{
                    "@type": "ContactPoint",
                    "telephone": "+237XXXXXXXXX",
                    "contactType": "customer service",
                    "areaServed": "CM",
                    "availableLanguage": ["French", "English"]
                  }]
                }
            @endverbatim

        </script>
@endsection

@section('title')
    Contactez CIB Construction | Devis Gratuit pour vos Projets BTP
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
    @vite(['resources/js/pages/contact.js', 'resources/css/pages/contact.css'])
@endpush