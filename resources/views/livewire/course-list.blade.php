<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">

    {{-- Barre de Filtres & Recherche --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between border-b border-border pb-6 mb-12 gap-6">
        <nav class="flex flex-wrap gap-6 text-sm font-medium">
            <button wire:click="selectCategory(null)"
                class="{{ is_null($selectedCategory) ? 'text-gcp-primary-color border-b-2 border-gcp-primary-color' : 'text-muted-foreground hover:text-foreground' }} pb-2 transition-all">
                Toutes les formations
            </button>
            @foreach($categories as $category)
                <button wire:click="selectCategory({{ $category->id }})"
                    class="{{ $selectedCategory == $category->id ? 'text-gcp-primary-color border-b-2 border-gcp-primary-color' : 'text-muted-foreground hover:text-foreground' }} pb-2 transition-all">
                    {{ $category->name }}
                </button>
            @endforeach
        </nav>

        <form class="relative w-full md:w-64" onsubmit="event.preventDefault();">
            <input wire:model.live.debounce.300ms="search" type="text" placeholder="Rechercher une vidéo..."
                class="w-full bg-white ps-3 border-b border-border focus:border-gcp-primary-color outline-none py-2 text-sm">
            <i class="fa-solid absolute fa-magnifying-glass top-1/2 -translate-y-1/2 right-2"></i>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
        @forelse($courses as $course)
            <article class="group" wire:key="course-{{ $course->id }}">
                <a href="{{ route('formation.show', $course->slug) }}"
                    class="relative block overflow-hidden rounded-2xl mb-6 aspect-video">
                    <img src="{{ $course->getFirstMediaUrl('course_thumbnails') ?: 'https://img.youtube.com/vi/' . $course->youtube_id . '/maxresdefault.jpg' }}"
                        alt="{{ $course->title }}"
                        class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                    <div
                        class="absolute bottom-3 z-20 right-3 bg-black/80 text-white text-[10px] font-bold px-2 py-1 rounded">
                        {{ $course->duration }}
                    </div>

                    <div class="absolute top-3 left-3 z-20">
                        <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest shadow-sm
                                        {{ $course->level == 'Débutant' ? 'bg-blue-500/50 text-white' : '' }}
                                        {{ $course->level == 'Intermédiaire' ? 'bg-orange-500/50 text-white' : '' }}
                                        {{ $course->level == 'Avancé' ? 'bg-red-500/50 text-white' : '' }}">
                            {{ $course->level }}
                        </span>
                    </div>
                    <div
                        class="absolute h-full z-10 w-full inset-0 text-6xl bg-linear-to-t from-[rgba(253,128,18,0.4)] to-[rgba(0,0,0,0.4)] flex items-center justify-center group">
                        <span class="bg-white transition-all group-hover:opacity-100 group-hover:translate-y-0 size-17 rounded-full opacity-0 translate-y-4 flex items-center justify-center">
                            <i class="fa-solid fa-play text-lg text-gcp-primary-color"></i>
                        </span>
                    </div>
                </a>

                <div class="flex flex-col gap-2">
                    <div
                        class="flex items-center justify-between text-[10px] font-bold uppercase tracking-widest text-muted-foreground">
                        <span>{{ $course->videoCategory->name }}</span>
                        <span class="flex items-center gap-1">
                            <i class="fa-solid fa-eye"></i> {{ number_format($course->views_count) }}
                        </span>
                    </div>

                    <h2
                        class="text-2xl font-bold text-foreground line-clamp-1 leading-tight group-hover:text-gcp-primary-color transition-colors">
                        <a href="{{ route('formation.show', $course->slug) }}">{{ $course->title }}</a>
                    </h2>

                    <p class="text-muted-foreground line-clamp-2">
                        {{ $course->summary }}
                    </p>

                    <div class="mt-2">
                        <a href="{{ route('formation.show', $course->slug) }}"
                            class="flex items-center gap-2 text-sm font-bold text-gcp-primary-color group-hover:gap-3 transition-all">
                            Regarder la vidéo
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </a>
                    </div>
                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center">
                <p class="text-muted-foreground text-lg">Aucune formation ne correspond à votre recherche.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-20">
        {{ $courses->links() }}
    </div>
</div>