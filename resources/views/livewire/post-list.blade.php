<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-border pb-6 mb-12 gap-6">
        <nav class="flex flex-wrap gap-6 text-sm font-medium">
            <button 
                wire:click="selectCategory(null)"
                class="{{ is_null($selectedCategory) ? 'text-gcp-primary-color border-b-2 border-gcp-primary-color' : 'text-muted-foreground hover:text-foreground' }} pb-2 transition-all"
            >
                Tous les articles
            </button>
            @foreach($categories as $category)
                <button 
                    wire:click="selectCategory({{ $category->id }})"
                    class="{{ $selectedCategory == $category->id ? 'text-gcp-primary-color border-b-2 border-gcp-primary-color' : 'text-muted-foreground hover:text-foreground' }} pb-2 transition-all"
                >
                    {{ $category->name }}
                </button>
            @endforeach
        </nav>

        <div class="relative w-full md:w-64">
            <input 
                wire:model.live.debounce.300ms="search"
                type="text" 
                placeholder="Rechercher un article..."
                class="w-full bg-white ps-3 border-b border-border focus:border-gcp-primary-color outline-none py-2 text-sm"
            >
            <i class="fa-solid absolute fa-magnifying-glass top-1/2 -translate-y-1/2 right-2"></i>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-16">
        @forelse($posts as $post)
            <article class="group" wire:key="post-{{ $post->id }}">
                <a href="{{ route('blog.show', $post->slug) }}" class="block overflow-hidden rounded-2xl mb-6 aspect-16/10">
                    <img 
                        src="{{ $post->getFirstMediaUrl('blog_posts') ?: asset('images/default.jpg') }}" 
                        alt="{{ $post->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105"
                    >
                </a>
                
                <div class="flex flex-col gap-4">
                    <h2 class="text-2xl font-bold text-foreground leading-tight group-hover:text-gcp-primary-color transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h2>
                    
                    <div class="flex items-center justify-between">
                        <span class="px-4 py-1.5 border border-border rounded-full text-[10px] font-bold uppercase tracking-widest text-muted-foreground">
                            {{ $post->blogCategory->name }}
                        </span>
                        <a href="{{ route('blog.show', $post->slug) }}" class="flex items-center gap-2 text-sm font-bold text-gcp-primary-color group-hover:gap-3 transition-all">
                            Lire l'article
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-muted-foreground text-lg">Aucun article ne correspond à votre recherche.</p>
            </div>
        @endforelse
    </div>

    <div class="mt-20">
        {{ $posts->links() }}
    </div>
</div>