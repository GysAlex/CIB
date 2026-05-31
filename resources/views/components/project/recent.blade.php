@php
    $recentProjects = [
        [
            'title' => 'Résidence Privée Cité Chirac',
            'client' => 'Client Privé',
            'location' => 'Douala, Yassa Cité Chirac',
            'date' => 'Mars 2026',
            'category' => 'Construction Résidentielle',
            'image' => asset('images/project/chirac.png'),
            'description' => 'Étude architecturale, d’ingénierie et réalisation complète du Gros œuvre et de la Voirie et Réseau Divers (VRD) pour une villa moderne de type R+1 s’étendant sur une superficie de 130 m².'
        ],
        [
            'title' => 'Complexe Mixte Yassa',
            'client' => 'Institutionnel religieux / Commercial',
            'location' => 'Douala, Yassa',
            'date' => 'Janvier 2026',
            'category' => 'Établissement Mixte',
            'image' => asset('images/project/projet1.jpeg'),
            'description' => 'Étude architecturale, d’ingénierie et mission complète de contrôle pour un complexe d’envergure de type SS+R+MEZ+8 de 490 m², contenant principalement une habitation commerciale.'
        ],
        [
            'title' => 'Siège Administratif PAK',
            'client' => 'Port Autonome de Kribi',
            'location' => 'Kribi, Zone Portuaire',
            'date' => 'Décembre 2025', 
            'category' => 'Bâtiment Administratif',
            'image' => asset('images/project/projet3.jpg'),
            'description' => 'Étude d’ingénierie approfondie et élaboration rigoureuse du Dossier d’Appel d’Offres (DAO) pour la future Direction Générale en R+5 sur une surface plancher de 1 167 m².'
        ],
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20" x-data="{ 
    currentIndex: 1, 
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
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2">
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
                    class="hover:bg-gcp-primary-color hover:text-white py-3 px-4 border border-gcp-primary-color/70 disabled:bg-gray-200 disabled:border-0 disabled:cursor-not-allowed text-gcp-primary-color cursor-pointer bg-white/90 disabled:text-gray-300 transition-all flex items-center gap-2 group "
                    :disabled="currentIndex == 0">
                    <i class="fa-solid fa-arrow-left duration-400"></i>
                </button>
                <button @click="next()"
                    class="hover:bg-gcp-primary-color hover:text-white py-3 px-4 border border-gcp-primary-color/70 disabled:bg-gray-200 disabled:border-0 disabled:cursor-not-allowed text-gcp-primary-color cursor-pointer bg-white/90 disabled:text-gray-300 transition-all flex items-center gap-2 group "
                    :disabled="currentIndex == 2">
                    <i class="fa-solid fa-arrow-right duration-400"></i>
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