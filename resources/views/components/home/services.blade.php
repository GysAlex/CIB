@php
    $services = [
        [
            'id' => '01',
            'title' => 'Conception & Architecture',
            'content' => 'Modélisation 3D et plans architecturaux optimisés pour allier esthétique moderne, fonctionnalité et respect des normes.',
            'image' => asset('images/services/hero2.jpeg')
        ],
        [
            'id' => '02',
            'title' => 'Gros Œuvre',
            'content' => 'Une exécution rigoureuse de vos structures porteuses, garantissant la solidité et la pérennité de vos édifices.',
            'image' => asset('images/services/hero2.jpeg')
        ],
        [
            'id' => '03',
            'title' => 'Domotique & Smart Home',
            'content' => 'Installation de systèmes intelligents pour le contrôle de l’éclairage, de la sécurité et du climat en temps réel.',
            'image' => asset('images/services/hero2.jpeg')
        ],
        [
            'id' => '04',
            'title' => 'Gestion de Chantier Digitale',
            'content' => 'Suivi transparent via notre plateforme : rapports d’avancement, gestion des livrables et notifications clients.',
            'image' => asset('images/services/hero2.jpeg')
        ],
        [
            'id' => '05',
            'title' => 'Énergies Renouvelables',
            'content' => 'Intégration de solutions photovoltaïques et gestion intelligente pour réduire votre empreinte carbone et vos factures.',
            'image' => asset('images/services/hero2.jpeg')
        ],
        [
            'id' => '06',
            'title' => 'Finitions de Précision',
            'content' => 'Second œuvre et décoration d’intérieur : nous apportons le soin final qui transforme un bâtiment en œuvre d’exception.',
            'image' => asset('images/services/hero2.jpeg')
        ],
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30" id="service">
    <div class="flex items-center justify-center">
        <span
            class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2 uppercase tracking-widest">
            Expertises & Services
        </span>
    </div>

    <div class="flex flex-col gap-4">
        <h2 class="max-w-3xl serviceMainText text-4xl md:text-5xl mx-auto text-center text-foreground font-medium leading-tight">
            Des solutions innovantes pour des <span class="text-gcp-primary-color">bâtiments d'avenir</span>
        </h2>
        <p class="text-muted-foreground max-w-2xl mx-auto text-center text-lg">
            Nous fusionnons l'ingénierie civile de précision avec les dernières technologies numériques pour donner vie
            à vos projets immobiliers les plus ambitieux.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-10 gap-x-6 mt-8 pb-4 overflow-hidden">

        @foreach ($services as $service)
            <div class="card flex flex-col w-full gap-4 group">
                <div
                    class="number font-bold text-3xl text-gcp-primary-color/20 group-hover:text-gcp-primary-color transition-colors duration-300">
                    {{ $service['id'] }}
                </div>
                <div class="title text-foreground text-xl font-semibold uppercase">
                    {{ $service['title'] }}
                </div>
                <div class="content text-muted-foreground">
                    {{ $service['content'] }}
                </div>
                <div class="image h-48">
                    <img src=" {{ $service['image'] }} " alt="{{ $service['title'] }}"
                        class="group-hover:scale-102 transition-transform duration-500 rounded-xl">
                </div>
            </div>
        @endforeach
    </div>
</div>