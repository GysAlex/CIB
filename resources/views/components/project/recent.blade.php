@php
    $recentProjects = [
        [
            'title' => 'Villa Moderne Golf - Yaoundé',
            'description' => 'Conception 3D complète et réalisation en gros œuvre d\'une villa contemporaine de 5 chambres. Intégration de solutions domotiques et finitions d\'architecture haut de gamme.',
            'image' => 'images/project/projet1.jpeg'
        ],
        [
            'title' => 'Complexe Résidentiel Bonamoussadi - Douala',
            'description' => 'Construction d\'un immeuble de rapport R+3 comprenant des appartements modernes et sécurisés. Optimisation des espaces et verdissement des balcons pour un confort durable.',
            'image' => 'images/project/projet2.jpeg'
        ],
        [
            'title' => 'Rénovation d\'un Siège Commercial - Akwa',
            'description' => 'Modernisation complète des espaces de travail d\'une entreprise locale. Réfection électrique, second œuvre architectural et ravalement de façade en verre intelligent.',
            'image' => 'images/project/projet3.jpg'
        ],
        [
            'title' => 'Duplex Éco-Responsable - Kribi',
            'description' => 'Projet de construction côtière innovant alliant architecture bioclimatique, gestion autonome des eaux et optimisation thermique pour faire face au climat tropical.',
            'image' => 'images/project/projet3.jpg' 
        ],
        [
            'title' => 'Bâtiment Logistique & Bureaux - Bonabéri',
            'description' => 'Ingénierie civile et exécution des structures en béton armé pour une plateforme de stockage industriel, incluant un bloc administratif haut standing connecté.',
            'image' => 'images/project/projet1.jpeg'
        ]
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
    <div class="flex items-center justify-center md:justify-start">
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2">
            Projets récents
        </span>
    </div>
    <div class="flex flex-col md:flex-row-reverse mt-4 gap-10 h-120">

        <div style="--swiper-navigation-color: #fff; " class="swiper mySwiper2 h-full w-full md:w-[80%]">
            <div class="swiper-wrapper h-full">
                @foreach($recentProjects as $project)
                    <div class="swiper-slide group flex items-center justify-center relative">
                        <div class="absolute w-full h-full rounded-3xl p-4 lg:p-6 flex flex-col items-start gap-2 justify-between text-white" style="background-image: linear-gradient(0deg,#0000318a 15%, transparent 50% );">
                            <h1 class="bg-white/60 text-base md:text-lg text-gcp-primary-color opacity-0 -translate-y-5 group-[.swiper-slide-active]:translate-y-0 group-[.swiper-slide-active]:opacity-100 transition-all duration-500 delay-300 rounded-4xl px-3 py-2 capitalize font-medium">
                                {{ $project['title'] }}
                            </h1>
                            <p class="w-[90%] text-white text-base md:text-lg md:w-[70%] opacity-0 line-clamp-3 mb-6 group-[.swiper-slide-active]:opacity-100 translate-y-5 group-[.swiper-slide-active]:translate-y-0 transition-all duration-500 delay-700">
                                {{ $project['description'] }}
                            </p>
                        </div>
                        <img loading="lazy" class="object-cover w-full h-full rounded-3xl" src="{{ asset($project['image']) }}" alt="{{ $project['title'] }}" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>

        <div class="swiper mySwiper h-40 md:h-full w-full md:w-[20%]">
            <div class="swiper-wrapper">
                @foreach($recentProjects as $project)
                    <div class="swiper-slide relative rounded-3xl group">
                        <div class="absolute w-full h-full flex cursor-pointer group-[not(.swiper-slide-thumb-active)]:cursor-normal items-center justify-center bg-black opacity-70 group-[.swiper-slide-thumb-active]:opacity-0 z-10 rounded-3xl">
                            <span class="flex items-center group-[swiper-slide-thumb-active)]:opacity-0 opacity-0 group-hover:opacity-100 translate-y-full transition-all duration-300 gap-1 bg-white/35 text-white px-3 py-2 rounded-3xl font-medium group-hover:translate-y-0">
                                <i class="fa-solid fa-eye"></i>
                                Visualiser
                            </span>
                        </div>
                        <img loading="lazy" class="object-cover w-full h-full rounded-3xl" src="{{ asset($project['image']) }}" alt="{{ $project['title'] }}" />
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</div>