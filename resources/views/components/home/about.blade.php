@php
    $stats = [
        ['value' => '08', 'label' => 'Années d’expertise', 'suffix' => '+'],
        ['value' => '45', 'label' => 'Projets livrés', 'suffix' => '+'],
        ['value' => '99', 'label' => 'Taux de satisfaction', 'suffix' => '%'],
        ['value' => '4.9', 'label' => 'Note moyenne clients', 'suffix' => '/5'],
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28" id="about">
    <div class="flex items-center justify-center md:justify-start">
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2">
            À Propos
        </span>
    </div>

    <div class="flex items-end justify-between flex-wrap gap-y-6">
        <h2
            class="max-w-3xl mx-auto md:mx-0 about-title text-3xl md:text-4xl lg:text-5xl text-foreground font-medium text-center md:text-start leading-tight">
            L'alliance de l'expertise <span class="text-gcp-secondary-color font-semibold">immobilière</span> et de la
            révolution <span class="text-gcp-primary-color font-semibold">digitale</span>.
        </h2>
        <div class="mx-auto md:mx-0">
            <a href="{{ route('project') }}"
                class="hover:bg-white py-3 px-4 border border-gcp-primary-color/70 cursor-pointer bg-white/90 text-gcp-primary-color transition-all flex items-center gap-2 group ">
                <span class="text-[14px] min-w-max">Voir nos projets</span>
                <i class="fa-solid fa-arrow-right group-hover:translate-x-1 transition-all duration-400"></i>
            </a>
        </div>
    </div>

    <div
        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 place-content-center gap-x-20 gap-y-8 text-foreground font-medium justify-between flex-wrap mt-8">
        @foreach ($stats as $stat)
            <div class="stat flex md:mx-0 mx-auto flex-col gap-4 justify-center">
                <div class="h-0.5 bg-gcp-secondary-color/20">

                </div>
                <div class="flex items-center gap-1 justify-center">
                    <span class="text-5xl lg:text-6xl text-center text-muted-foreground"
                        data-target="{{ $stat['value'] }}">0</span>
                    <span class="text-5xl lg:text-6xl text-center text-muted-foreground">{{ $stat['suffix'] }}</span>
                </div>
                <div class="text-muted-foreground capitalize text-center">
                    {{ $stat['label'] }}
                </div>
            </div>
        @endforeach
    </div>
</div>