<div class="bg-[#040017]">
    <div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30 pb-20">
        <div class="flex lg:items-center justify-between gap-4 flex-col lg:flex-row">
            <div class="text-4xl lg:text-5xl text-white">
                Quelques réalisations
            </div>
            <div class="text-muted max-w-2xl">
                Un aperçu de notre savoir-faire en ingénierie et maîtrise d'œuvre. Des fondations spéciales aux
                architectures modernes, nous bâtissons avec précision pour garantir la pérennité de vos investissements
                immobiliers
            </div>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 mt-8" x-data="{ 
            currentIndex: 0,
            projects: [
                {
                    title: 'Projet de construction d’un R+1',
                    category: 'Habitation résidentielle',
                    year: '2024',
                    client: 'Privé (Yassa cité Chirac)',
                    image: '{{ asset('images/home_projects/projet2.jpeg') }}',
                    desc: 'Étude architecturale, d’ingénierie et réalisation complète du Gros œuvre et de la Voirie et Réseau Divers (VRD) sur une surface de 130 m² / 300 m² à Douala.'
                },
                {
                    title: 'Immeuble SS+R+MEZ+8',
                    category: 'Établissement Mixte (Banque & Commerce)',
                    year: '2025',
                    client: 'Institutionnel (Akwa - Douala)',
                    image: '{{ asset('images/home_projects/projet1.jpeg') }}',
                    desc: 'Étude architecturale, d’ingénierie et Mission complète de contrôle pour un complexe d’envergure de 490 m² / 550 m² incluant sous-sol, mezzanine et 8 étages.'
                },
                {
                    title: 'Direction Générale PAK (R+5)',
                    category: 'Bâtiment Administratif / Tertiaire',
                    year: '2026',
                    client: 'Port Autonome de Kribi',
                    image: '{{ asset('images/home_projects/projet_3.png') }}',
                    desc: 'Étude approfondie d’ingénierie et élaboration du Dossier d’Appel d’Offres (DAO) pour une infrastructure moderne de 1 167 m² à Kribi.'
                }
            ]
        }">
            <div class="md:col-span-2 h-120 relative overflow-hidden ">
                <template x-for="(project, index) in projects">
                    <img loading="lazy" :src="project.image" :alt="project.title"
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