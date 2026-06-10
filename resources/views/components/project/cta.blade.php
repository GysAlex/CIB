@php
    $slides = [
        [
            'image' => 'images/hero2.jpeg',
            'alt' => 'Conception et Visualisation 3D',
            'badge' => 'Technologie',
            'title' => 'Visualisation 3D incluse',
            'icon' => 'fa-solid fa-vr-cardboard'
        ],
        [
            'image' => 'images/cta/cat2.jpeg', // Utilisation de l'image de ton autre section
            'alt' => 'Gros Œuvre et Maçonnerie',
            'badge' => 'Expertise',
            'title' => 'Gros œuvre & Rénovation',
            'icon' => 'fa-solid fa-helmet-safety'
        ],
        [
            'image' => 'images/cta/cta3.jpeg', // Tu pourras changer par une troisième image si nécessaire
            'alt' => 'Construction Intelligente au Cameroun',
            'badge' => 'Innovation',
            'title' => 'Bâtiment connecté & Durable',
            'icon' => 'fa-solid fa-house-laptop'
        ]
    ];
@endphp

<div class="bg-gcp-primary-color/20">
    <div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <div class="flex flex-col gap-2">
                <h2 class="text-4xl md:text-5xl capitalize font-medium text-[#1e262f] leading-tight">
                    Un rêve, une réalisation intelligente, <span class="text-gcp-primary-color">CIB donne vie à votre
                        projet</span>
                </h2>
                <p class="text-muted-foreground text-lg leading-relaxed">
                    De la villa privée au complexe commercial, nous transformons vos idées en structures durables. Notre
                    force ? Une expertise BIM unique au Cameroun pour sécuriser et optimiser vos projets.
                </p>
                <div class="h-full flex items-end justify-start">
                    <a href="{{ route('contact') }}"
                        class="hover:bg-white mt-4 py-3 px-4 w-fit cursor-pointer bg-white text-gcp-primary-color transition-all flex items-center gap-2 group ">
                        <span class="text-[14px] font-medium min-w-max">Demarrer mon projet</span>
                        <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-all duration-400"></i>
                    </a>
                </div>

            </div>
            <div class="max-w-150 h-100 w-full">
                <div class="swiper myFirstSwiper w-full h-full">
                    <div class="swiper-wrapper">
                        <!-- Slides -->
                        @foreach($slides as $slide)
                            <div class="swiper-slide group h-100 relative lg:order-2 overflow-hidden rounded-2xl">
                                <img src="{{ asset($slide['image']) }}" alt="{{ $slide['alt'] }}"
                                    class="absolute inset-0 w-full h-full object-cover duration-8000 group-[.swiper-slide-active]:scale-120" style="transition-timing-function: : ease-in-out;">

                                <div class="absolute inset-0 bg-linear-to-r from-white/20 to-transparent lg:hidden"></div>

                                <div
                                    class="absolute bottom-8 right-8 opacity-0 translate-y-10 group-[.swiper-slide-active]:opacity-100 group-[.swiper-slide-active]:translate-y-0 transition-all duration-400 delay-200  bg-white/90 backdrop-blur-md p-4 rounded-2xl shadow-xl border border-white/20 hidden md:flex items-center gap-4">
                                    <div
                                        class="size-10 bg-gcp-primary-color/10 rounded-full flex items-center justify-center text-gcp-primary-color">
                                        <i class="{{ $slide['icon'] }}"></i>
                                    </div>
                                    <div class="flex flex-col">
                                        <span class="text-[10px] font-bold text-gray-400 uppercase">
                                            {{ $slide['badge'] }}
                                        </span>
                                        <span class="text-xs font-bold text-[#1e262f]">
                                            {{ $slide['title'] }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                    <!-- If we need pagination -->
                    <div class="swiper-pagination" style="color: var(--bg-gcp-primary-color) !important"></div>
                </div>
            </div>
        </div>
    </div>
</div>