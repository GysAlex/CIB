<div class=" hero-section max-w-7xl relative mx-auto px-4 sm:px-6 lg:px-8 flex flex-col items-center gap-5 pt-30  mb-10" id="hero">
    <div class="absolute size-80 bg-gcp-primary-color top-0 left-0 -z-1 blur-3xl opacity-5 backhero"
        style="border-radius: 339px 93px 100px 500px;">

    </div>
    <div class="absolute size-80 bg-gcp-primary-color bottom-0 right-0 -z-1 blur-3xl opacity-5 translate-y-[50%] backhero2"
        style="border-radius: 339px 93px 100px 500px;">

    </div>
    <div class="hero-badge flex items-center gap-2 border border-border py-2 px-4 rounded-full w-fit">
        <span class="size-1.5 bg-gcp-secondary-color rounded-full"></span>
        <span class="text-[12px] text-gcp-gray-800 capitalize font-mediun">{{ $badge }}</span>
    </div>

    <div class="flex flex-col gap-6 text-center lg:max-w-5xl max-w-4xl">
        <h1 class="text-center capitalize mainText gcp-headline font-medium text-foreground text-5xl lg:text-6xl leading-tight">
            {{ $normalTitleText }} <span class=" text-gcp-primary-color">{{ $coloredTitleText }}</span>
        </h1>

        <p class="text-muted-foreground text-lg md:text-xl max-w-2xl mx-auto leading-relaxed project-desc">
            {{
                $heroDescription
            }}
        </p>
    </div>

</div>