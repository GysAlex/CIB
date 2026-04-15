<div class="bg-[#040017]">
    <div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30 pb-20">
        <div class="flex lg:items-center justify-between gap-4 flex-col lg:flex-row">
            <div class="text-4xl lg:text-5xl text-white">
                Quelques réalisations
            </div>
            <div class="text-muted max-w-2xl">
                Lorem ipsum, dolor sit amet consectetur adipisicing elit. Fuga eius voluptatum elit. Fuga eius
                voluptatum luptatum eli
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8" x-data="{ 
            currentIndex: 0,
            projects: [
                {
                    title: 'Résidence Nitcheu',
                    category: 'Résidence Personnelle',
                    year: '2024',
                    client: 'M. Bilong',
                    image: '{{ asset('images/hero4.jpg') }}',
                    desc: 'Conception d’une villa moderne alliant domotique avancée et architecture bioclimatique pour un confort optimal.'
                },
                {
                    title: 'Immeuble Horizon',
                    category: 'Promotion Immobilière',
                    year: '2025',
                    client: 'SCI Horizon',
                    image: '{{ asset('images/hero3.jpg') }}',
                    desc: 'Un complexe résidentiel intelligent au cœur de Douala, optimisé pour l’efficacité énergétique.'
                },
                {
                    title: 'Villa Emeraude',
                    category: 'Haut Standing',
                    year: '2024',
                    client: 'Mme. Ewane',
                    image: '{{ asset('images/hero2.jpeg') }}',
                    desc: 'Intégration de solutions de gestion d’énergie solaire et système de sécurité centralisé.'
                }
            ]
        }">
            <div class="md:col-span-2 h-120 relative overflow-hidden ">
                <template x-for="(project, index) in projects">
                    <img :src="project.image" :alt="project.title"
                        class="h-full w-full object-cover absolute inset-0 z-10 transition-all duration-700 ease-in-out"
                        :class="currentIndex === index ? 'opacity-100 scale-105' : 'opacity-0 scale-100'">
                </template>

                <div
                    class="absolute inset-0 z-20 bg-linear-to-t from-[#040017] via-transparent to-transparent flex items-end">
                    <div class="w-[90%] mx-auto pb-8 text-muted gcp-body transition-all duration-500"
                        x-text="projects[currentIndex].desc">
                    </div>
                </div>
            </div>

            <div class="flex flex-col h-full">
                <div class="flex flex-col gap-6 h-full">
                    <div>
                        <div class="px-4 py-1.5 border border-white/30 rounded-full text-muted text-xs uppercase tracking-widest w-fit"
                            x-text="projects[currentIndex].category">
                        </div>
                    </div>

                    <div class="flex flex-col gap-3">
                        <div class="text-3xl text-white gcp-headline transition-all"
                            x-text="projects[currentIndex].title">
                        </div>
                        <div class="flex flex-col gap-1">
                            <div class="text-muted flex items-center gap-2">
                                <span class="text-gcp-primary-color">●</span>
                                Année : <span class="text-white" x-text="projects[currentIndex].year"></span>
                            </div>
                            <div class="text-muted flex items-center gap-2">
                                <span class="text-gcp-secondary-color">●</span>
                                Client : <span class="text-white" x-text="projects[currentIndex].client"></span>
                            </div>
                        </div>
                    </div>

                    <div class="relative h-full flex items-end">
                        <div class="flex flex-row justify-between gap-4 w-full">
                            <template x-for="(project, index) in projects">
                                <button @click="currentIndex = index"
                                    class="flex flex-col gap-2 grow cursor-pointer group outline-none">
                                    <div class="h-1 w-full bg-muted/20 relative overflow-hidden">
                                        <div class="absolute inset-0 bg-white transition-transform duration-500 origin-left"
                                            :class="currentIndex === index ? 'scale-x-100' : 'scale-x-0 group-hover:scale-x-50'">
                                        </div>
                                    </div>
                                    <span class="text-end text-xs font-bold transition-colors"
                                        :class="currentIndex === index ? 'text-white' : 'text-muted/50'"
                                        x-text="'0' + (index + 1)">
                                    </span>
                                </button>
                            </template>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>