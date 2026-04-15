@php
    $recentProjects = [
        [
            'title' => 'Villa Oasis Intelligente',
            'client' => 'Famille Etoundi',
            'location' => 'Yaoundé, Bastos',
            'date' => 'Mars 2026',
            'category' => 'Construction Résidentielle',
            'image' => asset('images/services/hero2.jpeg'),
            'description' => 'Une résidence de luxe intégrant une gestion intelligente de l’énergie solaire et une ventilation naturelle optimisée pour le climat équatorial. Alliant confort moderne et architecture durable.'
        ],
        [
            'title' => 'Complexe Blue Tower',
            'client' => 'SCI Horizon',
            'location' => 'Douala, Bonanjo',
            'date' => 'Janvier 2026',
            'category' => 'Immobilier Professionnel',
            'image' => asset('images/services/hero2.jpeg'),
            'description' => 'Siège social innovant au cœur du quartier des affaires. Structure à haute performance thermique avec système de gestion technique du bâtiment (GTB) centralisé.'
        ],
        [
            'title' => 'Eco-Logements Kribi',
            'client' => 'Promoteurs Littoral',
            'location' => 'Kribi, Zone Balnéaire',
            'date' => 'Décembre 2025',
            'category' => 'Aménagement Touristique',
            'image' => asset('images/services/hero2.jpeg'),
            'description' => 'Ensemble de bungalows écologiques utilisant des matériaux locaux stabilisés et une domotique de pointe pour la sécurité et la gestion à distance.'
        ],
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-30 pb-20" x-data="{ 
    currentIndex: 0, 
    projects: {{ json_encode($recentProjects) }},
    next (){
        if(this.currentIndex < this.projects.length -1)
            this.currentIndex = this.currentIndex + 1
        else
            return 
    },

    prev (){
        if(this.currentIndex > 0 )
            this.currentIndex = this.currentIndex - 1
        else
            return 
    }
}">
    <div class="flex items-center justify-center md:justify-start">
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[12px] font-bold rounded-3xl px-3 py-2">
            Projet recents
        </span>
    </div>
    <div class="flex flex-col mt-4 gap-4">
        <div class="flex items-start md:items-center justify-between md:flex-row flex-col">
            <div class="text-foreground font-bold text-3xl" x-text="projects[currentIndex].title">

            </div>
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <span class="text-lg font-medium text-foreground" x-text="projects[currentIndex].client">

                </span>
                <div class="flex items-center gap-4">
                    <span class="size-3 rounded-full bg-gcp-primary-color">

                    </span>
                    <span class="text-foreground" x-text="projects[currentIndex].location">

                    </span>
                </div>

                <div class="flex items-center gap-4">
                    <span class="size-3 rounded-full bg-gcp-primary-color">

                    </span>
                    <span class="text-muted-foreground" x-text="projects[currentIndex].date">

                    </span>
                </div>

            </div>
        </div>
        <div class="h-120 relative w-full overflow-x-hidden">
            <template x-for="(project, index) in projects" :key="index">

                <img class="h-full absolute w-full object-cover duration-500 transition-all" :src="project.image"
                    :alt="project.title"
                    :class="index == currentIndex ? 'opacity-100 translate-x-0' : 'opacity-0 -translate-x-full' ">

            </template>
        </div>
        <span class="px-3 py-2 w-fit border border-border text-foreground rounded-3xl"
            x-text="projects[currentIndex].category">
            Maison de résidence
        </span>
        <div class="flex items-start md:items-center flex-col md:flex-row justify-between gap-10">
            <p class="text-foreground/60" x-text="projects[currentIndex].description">

            </p>

            <div class="gap-1 flex flex-row justify-end">
                <button @click="prev()"
                    class="hover:bg-gcp-primary-color py-3 px-4 border border-gcp-primary-color/70 disabled:bg-gray-200 disabled:border-0 disabled:cursor-not-allowed cursor-pointer bg-white/90 text-gcp-primary-color transition-all flex items-center gap-2 group "
                    :disabled="currentIndex == 0">
                    <i
                        class="fa-solid fa-arrow-left  group-hover:text-white group-hover:-translate-x-1 transition-all duration-400"></i>
                </button>
                <button @click="next()"
                    class="hover:bg-gcp-primary-color py-3 px-4 border border-gcp-primary-color/70 cursor-pointer bg-white/90 text-gcp-primary-color disabled:bg-gray-200 disabled:border-0 disabled:cursor-not-allowed transition-all flex items-center gap-2 group "
                    :disabled="currentIndex == 2">
                    <i
                        class="fa-solid fa-arrow-right group-hover:text-white group-hover:translate-x-1 transition-all duration-400"></i>
                </button>

            </div>
        </div>
        <div class="flex justify-center gap-2 mt-2">
            <template x-for="(dot, index) in projects" :key="index">
                <button @click="currentIndex = index" class="h-3 transition-all duration-300 rounded-full"
                    :class="currentIndex === index ? 'w-8 bg-gcp-primary-color' : 'w-3 bg-gcp-primary-color/20'">
                </button>
            </template>
        </div>
    </div>
</div>