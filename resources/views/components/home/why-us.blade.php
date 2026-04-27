@php
    $valeurs = [
        [
            'icon' => 'fa-shield-halved',
            'title' => 'Transparence Totale',
            'desc' => 'Grâce à notre plateforme digitale, suivez l’avancement de vos travaux et vos dépenses en temps réel, sans surprises.'
        ],
        [
            'icon' => 'fa-microchip',
            'title' => 'Innovation Technologique',
            'desc' => 'Nous intégrons l’intelligence artificielle et la domotique dès la conception pour des bâtiments connectés et évolutifs.'
        ],
        [
            'icon' => 'fa-leaf',
            'title' => 'Efficacité Énergétique',
            'desc' => 'Nos constructions optimisent la consommation d’énergie, réduisant vos factures tout en préservant l’environnement.'
        ],
        [
            'icon' => 'fa-handshake',
            'title' => 'Engagement Qualité',
            'desc' => 'Nous respectons scrupuleusement les normes de sécurité et utilisons des matériaux certifiés pour une durabilité garantie.'
        ]
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30 pb-20" id="why-us">
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-y-12 lg:gap-x-12">
        
        <div class="flex flex-col gap-6 col-span-2">
            <span class="text-gcp-primary-color w-fit bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-4 py-2 uppercase tracking-widest">
                Nos Valeurs
            </span>
            <h2 class="text-4xl whyTitle md:text-5xl font-medium text-foreground leading-tight">
                Pourquoi choisir <br class="hidden lg:block"> <span class="text-gcp-primary-color">CiB</span> ?
            </h2>
            
            <div class="h-full hidden lg:flex items-end justify-start pb-4">
                <a href="{{ route('contact') }}"
                    class="py-3.5 px-6 border border-gcp-primary-color cursor-pointer bg-transparent text-gcp-primary-color font-bold transition-all flex items-center gap-3 group ">
                    <span class="text-[14px]">Démarrer un projet</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-all duration-400"></i>
                </a>
            </div>
        </div>

        <div class="col-span-3 flex flex-col gap-12">
            <p class="text-2xl text-muted-foreground font-medium leading-relaxed">
                Nous ne construisons pas seulement des murs, nous bâtissons des infrastructures intelligentes adaptées aux défis de demain au Cameroun.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-12">
                @foreach($valeurs as $valeur)
                    <div class="flex flex-col gap-4 group card">
                        <div class="size-14 bg-gcp-primary-color/10 flex items-center justify-center rounded-xl group-hover:bg-gcp-primary-color transition-all duration-500">
                            <i class="fa-solid {{ $valeur['icon'] }} text-gcp-primary-color text-2xl group-hover:text-white transition-colors"></i>
                        </div>
                        <h3 class="title text-xl text-gcp-secondary-color font-bold">
                            {{ $valeur['title'] }}
                        </h3>
                        <p class="text-muted-foreground leading-relaxed">
                            {{ $valeur['desc'] }}
                        </p>
                    </div>
                @endforeach
            </div>

            <div class="h-full flex lg:hidden items-center justify-center mt-4">
                <a href="{{ route('contact') }}"
                    class="py-3.5 px-6 border border-gcp-primary-color cursor-pointer bg-transparent text-gcp-primary-color font-bold transition-all flex items-center gap-3 group ">
                    <span class="text-[14px]">Démarrer un projet</span>
                    <i class="fa-solid fa-arrow-right group-hover:translate-x-2 transition-all duration-400"></i>
                </a>
            </div>
        </div>
    </div>
</div>