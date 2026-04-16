<div class="bg-[#040017]">
    <div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30 pb-20">
        <div class="flex lg:items-center justify-between gap-4 flex-col ">
            <span
                class="text-gcp-primary-color bg-gcp-primary-color/10 text-[12px] font-bold rounded-3xl px-3 py-2">
                Technologie
            </span>
            <h2 class="text-4xl lg:text-5xl text-white text-center">
                Plongez au cœur de votre futur ouvrage avec la <span class="text-gcp-primary-color">réalité
                    virtuelle</span>
            </h2>
        </div>
        <div class="relative  w-full max-w-6xl mx-auto overflow-hidden mt-8">
            <div class="absolute -inset-10  rounded-full blur-[120px] pointer-events-none"></div>

            <div
                class="relative rounded-3xl overflow-hidden shadow-2xl border border-white/10 bg-[#161d24] h-110 md:h-125">
                <div x-data="{ isLoaded: false, isStarted: false }"
                    class="relative w-full h-full bg-[#161d24] rounded-3xl overflow-hidden group">

                    <div x-show="!isStarted"
                        class="absolute inset-0 z-20 flex flex-col items-center justify-center transition-all duration-700">

                        <img src="{{ asset('images/hero2.jpeg') }}"
                            class="absolute inset-0 w-full h-full object-cover opacity-40 group-hover:scale-105 transition-transform duration-1000">

                        <div class="absolute inset-0 bg-linear-to-t from-[#1e262f] via-transparent to-transparent">
                        </div>

                        <button @click="isStarted = true" class="relative flex flex-col items-center gap-6 group/btn">
                            <div
                                class="size-24 rounded-full bg-gcp-primary-color flex items-center justify-center shadow-[0_0_50px_rgba(255,107,0,0.3)] group-hover/btn:scale-110 group-hover/btn:shadow-[0_0_60px_rgba(255,107,0,0.5)] transition-all duration-500">
                                <i class="fa-solid fa-play text-white text-3xl ml-1"></i>
                            </div>
                            <div class="flex flex-col items-center">
                                <span class="text-white font-bold uppercase tracking-[0.3em] text-xs">Lancer
                                    l'expérience</span>
                                <span class="text-gray-400 text-[10px] mt-2 italic">Modèle 3D optimisé •
                                    {{ $location ?? 'Cameroun' }}</span>
                            </div>
                        </button>
                    </div>

                    <template x-if="isStarted">
                        <div class="w-full h-full">
                            <div x-show="!isLoaded"
                                class="absolute inset-0 z-30 flex flex-col items-center justify-center bg-[#1e262f]">
                                <div class="w-64 h-1 bg-white/5 rounded-full overflow-hidden">
                                    <div id="loading-bar-inner"
                                        class="h-full bg-gcp-primary-color transition-all duration-300"
                                        style="width: 0%">
                                    </div>
                                </div>
                                <span
                                    class="mt-4 text-[10px] text-gray-500 font-bold uppercase tracking-widest animate-pulse">
                                    Chargement des données BIM...
                                </span>
                            </div>

                            <model-viewer class="w-full h-full bg-black/30" src="{{ asset('3D/compressed') }}" ar
                                ar-modes="webxr scene-viewer quick-look" camera-controls auto-rotate
                                shadow-intensity="2" environment-intensity="1.5" exposure="1.2"
                                camera-orbit="0deg 90deg 60m" class="w-full h-full outline-none"
                                @progress="document.getElementById('loading-bar-inner').style.width = ($event.detail.totalProgress * 100) + '%'"
                                @load="isLoaded = true">

                            </model-viewer>
                            <div class="absolute top-6 left-6 z-30 flex flex-col gap-2" x-data="{ open: true }">

                                <button @click="open = !open" x-show="isLoaded"
                                    class="bg-white/10 backdrop-blur-md border border-white/20 p-3 rounded-xl text-white hover:bg-white/20 transition-all w-fit shadow-xl">
                                    <i class="fa-solid" :class="open ? 'fa-chevron-up' : 'fa-info-circle'"></i>
                                    <span x-show="!open"
                                        class="ml-2 text-[10px] font-bold uppercase tracking-widest">Infos Projet</span>
                                </button>

                                <div x-show="open && isLoaded" x-transition:enter="transition ease-out duration-300"
                                    x-transition:enter-start="opacity-0 -translate-y-4"
                                    x-transition:enter-end="opacity-100 translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    class="bg-black/50 md:bg-white/20 backdrop-blur-xl border border-white/10 rounded-2xl p-5 w-50 shadow-2xl text-white">

                                    <div class="flex flex-col gap-4">
                                        <div>
                                            <h4
                                                class="text-gcp-primary-color text-[10px] font-bold uppercase tracking-[0.2em] mb-1">
                                                Spécifications</h4>
                                            <p class="text-lg font-medium leading-tight">Résidence Horizon</p>
                                        </div>

                                        <hr class="border-white/10">

                                        <div class="space-y-3">
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400 text-xs">Type</span>
                                                <span class="text-xs font-semibold uppercase">Bâtiment R + 5</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400 text-xs">Surface</span>
                                                <span class="text-xs font-semibold">1,250 m²</span>
                                            </div>
                                            <div class="flex justify-between items-center">
                                                <span class="text-gray-400 text-xs">Statut</span>
                                                <span
                                                    class="flex items-center gap-1.5 text-[10px] font-bold text-green-400 bg-green-400/10 px-2 py-0.5 rounded">
                                                    <span
                                                        class="size-1.5 bg-green-400 rounded-full animate-pulse"></span>
                                                    EN COURS
                                                </span>
                                            </div>
                                        </div>

                                        <hr class="border-white/10">

                                        <p class="text-[11px] text-gray-300 leading-relaxed italic">
                                            Structure optimisée pour une isolation thermique naturelle, réduisant les
                                            besoins en climatisation de 30%.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </template>
                </div>
            </div>

            <div class="mt-8 flex flex-wrap justify-center gap-8 text-gray-400 text-sm font-medium">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-cube text-gcp-primary-color"></i>
                    <span>Modèle BIM Haute Fidélité</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-hand-pointer text-gcp-primary-color"></i>
                    <span>Interaction 360°</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-mobile-screen-button text-gcp-primary-color"></i>
                    <span>Compatible Réalité Augmentée</span>
                </div>
            </div>
        </div>
    </div>

</div>