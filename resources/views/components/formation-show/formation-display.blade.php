<div class="flex flex-col max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-32 md:pt-40">

    @php
        $shareUrl = urlencode(request()->fullUrl());
        $shareTitle = urlencode($course->title);
    @endphp

    <header class="hero-section flex flex-col items-center justify-center pb-7">
        <div class="text-start w-full mb-6">
            <a href="{{ route('formation') }}" class="text-gcp-secondary-color text-lg">
                <i class="fa-solid fa-arrow-left"></i>
                retour aux formations
            </a>
        </div>

        <div class="flex items-center justify-start md:justify-center w-full">
            <span
                class="px-3 py-1 bg-gcp-primary-color/10 text-gcp-primary-color text-sm font-bold rounded-full capitalize tracking-widest">
                {{ $course->videoCategory->name }}
            </span>
        </div>

    </header>

    <div class="flex flex-col items-start md:flex-row md:items-end md:justify-between my-6 gap-4">
        <h1 class="text-3xl md:text-4xl max-w-3xl font-bold text-foreground leading-tight">
            {{ $course->title }}
        </h1>

        <div class="flex flex-col items-start md:items-end gap-2 text-sm">
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-clock text-gcp-primary-color"></i>
                <span class="text-muted-foreground">Durée : {{ $course->duration }}</span>
            </div>
            <div class="flex items-center gap-2">
                <i class="fa-solid fa-layer-group text-gcp-primary-color"></i>
                <span class="text-muted-foreground">Niveau : {{ $course->level }}</span>
            </div>
        </div>
    </div>

    {{-- Lecteur Vidéo YouTube --}}
    <div class="overflow-hidden h-120 rounded-2xl aspect-video ">
        <iframe class="w-full h-full"
            src="https://www.youtube.com/embed/{{ $course->youtube_id }}?rel=0&modestbranding=1"
            title="{{ $course->title }}" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
            allowfullscreen>
        </iframe>
    </div>

    {{-- Corps de la formation --}}
    <div class="mb-20">
        <div class="prose prose-lg prose-slate max-w-none 
                    prose-headings:text-foreground prose-headings:font-bold
                    prose-p:text-muted-foreground prose-p:leading-relaxed
                    prose-a:text-gcp-primary-color hover:prose-a:underline
                    prose-img:rounded-2xl my-10">

            <div class="bg-gcp-primary-color/5 p-6 rounded-2xl mb-10 border-l-4 border-gcp-primary-color">
                <h3 class="mt-0 text-gcp-primary-color">Résumé de la session</h3>
                @if ($course->summary)
                    <p class="mb-0 italic">{{ $course->summary  }}</p>
                @else
                    <p class="mb-0 italic"> pas de résumé </p>
                @endif
            </div>

            {!! $course->description !!}
        </div>

        {{-- Footer de l'article : Stats & Partage --}}
        <div
            class="flex flex-col justify-start md:justify-between md:flex-row items-start md:items-center border-t border-border pt-4 gap-4">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-2 text-[12px]">

                    <div class="flex items-center gap-2 text-gcp-primary-color">
                        <i class="fa-solid fa-eye"></i>
                        <span class="font-bold">{{ number_format($course->views_count) }}</span> vues
                    </div>
                </div>
                <div class=" flex items-center gap-2">
                    <span class="size-12 flex items-center justify-center bg-gcp-primary-color rounded-full">
                        <i class="fa-solid fa-user text-white"></i>
                    </span>
                    <div class="flex flex-col gap-1">
                        <span class="text-muted-foreground/70">
                            par <span class="font-bold">{{ $course->user->name }}</span>
                        </span>
                        <span class="text-[12px]">
                            publié le <span class="">{{ $course->published_at->diffForHumans() }}</span>
                        </span>
                    </div>

                </div>
            </div>

            <div class="flex items-center gap-4">
                <span class="text-sm font-bold text-foreground/60 tracking-wider">Partager la formation :</span>
                <div class="flex gap-2">
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                        class="p-2 transition-colors">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>
                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank"
                        class="p-2 transition-colors">
                        <i class="fa-brands fa-linkedin text-xl"></i>
                    </a>
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
                        class="p-2 transition-colors">
                        <i class="fa-brands fa-facebook text-xl"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    <livewire:comment-system :model="$course"/>

    @if ($relatedCourses->count() > 0)
        <div class="bg-secondary/10  pb-15">
            <div class="max-w-7xl mx-auto">
                <h2 class="text-3xl font-bold text-foreground mb-6">Continuer votre apprentissage</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                    @foreach($relatedCourses as $related)
                        <article class="group">
                            <a href="{{ route('formation.show', $related->slug) }}"
                                class="relative block overflow-hidden rounded-2xl mb-6 aspect-video">
                                <img src="{{ $related->getFirstMediaUrl('course_thumbnails') ?: 'https://img.youtube.com/vi/' . $related->youtube_id . '/maxresdefault.jpg' }}"
                                    alt="{{ $related->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                                <div
                                    class="absolute bottom-3 z-20 right-3 bg-black/80 text-white text-[10px] font-bold px-2 py-1 rounded">
                                    {{ $related->duration }}
                                </div>
                                <div
                                    class="absolute h-full z-10 w-full inset-0 text-6xl bg-linear-to-t from-[rgba(253,128,18,0.4)] to-[rgba(0,0,0,0.4)] flex items-center justify-center group">
                                    <span
                                        class="bg-white transition-all group-hover:opacity-100 group-hover:translate-y-0 size-17 rounded-full opacity-0 translate-y-4 flex items-center justify-center">
                                        <i class="fa-solid fa-play text-lg text-gcp-primary-color"></i>
                                    </span>
                                </div>
                            </a>

                            <div class="flex flex-col gap-2">
                                <h2
                                    class="text-2xl font-bold text-foreground/80 line-clamp-1 leading-tight group-hover:text-gcp-primary-color transition-colors">
                                    <a href="{{ route('formation.show', $related->slug) }}">{{ $related->title }}</a>
                                </h2>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="px-4 py-1.5 border border-border rounded-full text-[10px] font-bold uppercase tracking-widest text-muted-foreground">
                                        {{ $related->videoCategory->name }}
                                    </span>
                                    <a href="{{ route('formation.show', $related->slug) }}"
                                        class="flex items-center gap-2 text-sm font-bold text-gcp-primary-color group-hover:gap-3 transition-all">
                                        Voir la vidéo
                                        <i class="fa-solid fa-play text-xs"></i>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
</div>