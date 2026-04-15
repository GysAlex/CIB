<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-30">
    <div class="flex items-center justify-center">
        <span
            class="text-gcp-primary-color bg-gcp-primary-color/10 text-[12px] font-bold rounded-3xl px-3 py-2 uppercase tracking-widest">
            Actualités & Expertises
        </span>
    </div>
    <div class="flex flex-col gap-4">
        <h2 class="max-w-3xl text-4xl md:text-5xl mx-auto text-center text-foreground font-medium leading-tight">
            Décrypter l'avenir de la <span class="text-gcp-primary-color">construction intelligente</span>
        </h2>
        <p class="text-muted-foreground max-w-2xl mx-auto text-center text-lg">
            Retrouvez nos derniers articles, guides pratiques et analyses sur les innovations du bâtiment, la domotique
            et la gestion durable de vos projets immobiliers.
        </p>
    </div>
    <div class="mt-8" x-data="{
    featuredPost: {
        id: 1,
        slug: 'choisir-le-bon-entrepreneur',
        title: 'Comment choisir le bon entrepreneur pour votre projet de construction',
        category: 'Guide Client',
        date: '10 Juillet 2025',
        author: 'Albert Sandy',
        readTime: '10 min',
        image: '{{ asset('images/hero4.jpg') }}'
    },
    posts: [
        {
            id: 2,
            slug: 'planifier-construction-commerciale',
            title: 'Planifier votre projet commercial de manière efficace et rentable',
            category: 'Conseils Construction',
            date: '21 Mai 2025',
            author: 'Albert Sandy',
            readTime: '5 min'
        },
        {
            id: 3,
            slug: 'importance-batiment-durable-2025',
            title: 'Pourquoi la construction durable et efficace est cruciale en 2026',
            category: 'Bâtiment Vert',
            date: '18 Mars 2025',
            author: 'Jordy Alba',
            readTime: '7 min'
        }
    ]
}">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">

            <article class="lg:col-span-7 group">
                <a :href="'/blog/' + featuredPost.slug" class="block relative overflow-hidden rounded-2xl mb-6">
                    <img :src="featuredPost.image" :alt="featuredPost.title"
                        class="w-full h-100 object-cover transition-transform duration-500 group-hover:scale-105">
                </a>

                <div class="flex items-center justify-between mb-4">
                    <span
                        class="px-3 py-1 border border-border rounded-full text-xs font-semibold text-muted-foreground uppercase tracking-wide"
                        x-text="featuredPost.category"></span>
                    <time class="text-sm text-muted-foreground" x-text="featuredPost.date"></time>
                </div>

                <h2 class="text-3xl font-bold text-foreground mb-4 leading-tight">
                    <a :href="'/blog/' + featuredPost.slug" class="hover:text-gcp-primary-color transition-colors"
                        x-text="featuredPost.title"></a>
                </h2>

                <div class="flex items-center gap-3 text-sm text-muted-foreground">
                    <span class="font-bold text-foreground" x-text="featuredPost.author"></span>
                    <span class="w-1.5 h-1.5 rounded-full bg-gcp-primary-color"></span>
                    <span x-text="'Lecture : ' + featuredPost.readTime"></span>
                </div>
            </article>

            <div class="lg:col-span-5 flex flex-col gap-8">
                <template x-for="(post, index) in posts" :key="index">
                    <article class="group border-b border-border pb-8 last:border-0">
                        <div class="flex items-center justify-between mb-4">
                            <span
                                class="px-3 py-1 border border-border rounded-full text-xs font-semibold text-muted-foreground uppercase tracking-wide"
                                x-text="post.category"></span>
                            <time class="text-sm text-muted-foreground" x-text="post.date"></time>
                        </div>

                        <h3 class="text-xl font-bold text-foreground mb-4 leading-snug">
                            <a :href="'/blog/' + post.slug" class="group-hover:text-gcp-primary-color transition-colors"
                                x-text="post.title"></a>
                        </h3>

                        <div class="flex items-center gap-3 text-sm text-muted-foreground">
                            <span class="font-bold text-foreground" x-text="post.author"></span>
                            <span class="w-1.5 h-1.5 rounded-full bg-gcp-primary-color"></span>
                            <span x-text="'Lecture : ' + post.readTime"></span>
                        </div>
                    </article>
                </template>
            </div>

        </div>
    </div>
</div>