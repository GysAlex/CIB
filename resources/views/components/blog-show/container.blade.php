<div class="flex flex-col max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-40">
    {{-- Header de l'article --}}

    @php
        $wordsPerMinute = 200;
        $wordCount = str_word_count(strip_tags($post->content));
        $minutes = ceil($wordCount / $wordsPerMinute);
        $time = $minutes > 1 ? $minutes . ' mins' : $minutes . ' min';

        $shareUrl = urlencode(request()->fullUrl());
        $shareTitle = urlencode($post->title);
    @endphp

    <header class=" hero-section flex flex-col items-center justify-center pb-7">
        <div class="text-start w-full mb-4">
            <a href="{{ route('blog') }}" class="text-gcp-secondary-color text-lg">
                <i class="fa-solid fa-arrow-left"></i>
                retour
            </a>
        </div>

        <span
            class="px-3 py-1 bg-gcp-primary-color/10 text-gcp-primary-color text-sm font-bold rounded-full capitalize tracking-widest">
            {{ $post->blogCategory->name }}
        </span>
    </header>

    <div class=" flex flex-col items-start md:flex-row md:items-end md:justify-between my-6 gap-4">
        <h1 class="text-3xl md:text-4xl max-w-3xl font-bold text-foreground leading-tight">
            {{ $post->title }}
        </h1>

        <div class="flex items-center justify-center gap-2 text-sm">
            <i class="fa-brands fa-readme text-gcp-primary-color"></i>
            <span class="text-muted-foreground">Temps de lecture : {{ $time }}</span>
        </div>
    </div>

    <div class="overflow-hidden h-120">
        <img src="{{ $post->getFirstMediaUrl('blog_posts') }}" alt="{{ $post->title }}"
            class="w-full h-full object-cover">
    </div>

    {{-- Corps de l'article --}}
    <div class="mb-20">
        <div class="prose prose-lg prose-slate max-w-none 
                    prose-headings:text-foreground prose-headings:font-bold
                    prose-p:text-muted-foreground prose-p:leading-relaxed
                    prose-a:text-gcp-primary-color hover:prose-a:underline
                    prose-img:rounded-2xl my-6">
            {!! $post->content !!}
        </div>

        {{-- Tags --}}

        <div
            class="flex flex-col justify-start md:justify-between md:flex-row items-start md:items-center border-t border-border pt-8 gap-4">
            <div class=" flex items-center gap-2">
                <span class="size-12 flex items-center justify-center bg-gcp-primary-color rounded-full">
                    <i class="fa-solid fa-user text-white"></i>
                </span>
                <span class="text-muted-foreground">
                    par <span class="font-bold">{{ $post->user->name }}</span>
                </span>
            </div>
            <div class="flex items-center gap-4 ">
                <span class="text-sm font-bold text-foreground/60 tracking-wider">Partager l'expertise :</span>

                <div class="flex gap-2">
                    <a href="https://wa.me/?text={{ $shareTitle }}%20{{ $shareUrl }}" target="_blank"
                        class="p-2 rounded-full  transition-colors"
                        title="Partager sur WhatsApp">
                        <i class="fa-brands fa-whatsapp text-xl"></i>
                    </a>

                    <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ $shareUrl }}" target="_blank"
                        class="p-2 rounded-full transition-colors"
                        title="Partager sur LinkedIn">
                        <i class="fa-brands fa-linkedin text-xl"></i>
                    </a>

                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}" target="_blank"
                        class="p-2 rounded-full transition-colors"
                        title="Partager sur Facebook">
                        <i class="fa-brands fa-facebook text-xl"></i>
                    </a>
                </div>
            </div>
            @if($post->blogTags->count() > 0)
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach($post->blogTags as $tag)
                            <span class="px-3 py-1 bg-gcp-primary-color/20 text-secondary-foreground text-xs rounded-full">
                                #{{ $tag->name }}
                            </span>
                        @endforeach
                    </div>

                </div>
            @endif
    </div>

    @if ($relatedPosts->count() > 0)
        <div class="bg-secondary/30 py-20">
            <div class="">
                <h2 class="text-3xl font-bold text-foreground mb-12">Vous aimeriez aussi...</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-12">
                    @forelse($relatedPosts as $post)
                        <article class="group">
                            <a href="{{ route('blog.show', $post->slug) }}"
                                class="block overflow-hidden rounded-2xl mb-6 aspect-16/10">
                                <img src="{{ $post->getFirstMediaUrl('blog_posts') ?: asset('images/default.jpg') }}"
                                    alt="{{ $post->title }}"
                                    class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                            </a>

                            <div class="flex flex-col gap-2">
                                <h2
                                    class="text-2xl font-bold text-foreground line-clamp-1 leading-tight group-hover:text-gcp-primary-color transition-colors">
                                    <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                                </h2>
                                <p class="text-muted/65 line-clamp-2" style="">
                                    {!! $post->content !!}
                                </p>
                                <div class="flex items-center justify-between">
                                    <span
                                        class="px-4 py-1.5 border border-border rounded-full text-[10px] font-bold uppercase tracking-widest text-muted-foreground">
                                        {{ $post->blogCategory->name }}
                                    </span>
                                    <a href="{{ route('blog.show', $post->slug) }}"
                                        class="flex items-center gap-2 text-sm font-bold text-gcp-primary-color group-hover:gap-3 transition-all">
                                        Lire l'article
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @empty

                    @endforelse
                </div>
            </div>
        </div>
    @endif

</div>