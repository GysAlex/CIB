@php
    $team = [
        [
            'name' => 'Kamba Joel',
            'role' => 'Ingénieur Civil Principal',
            'image' => asset('images/team/team.jpg'),
        ],
        [
            'name' => 'Fouda Marie',
            'role' => 'Architecte D.P.L.G',
            'image' => asset('images/team/team.jpg'),
        ],
        [
            'name' => 'Talla Samuel',
            'role' => 'Conducteur de Travaux',
            'image' => asset('images/team/team.jpg'),
        ],
        [
            'name' => 'Ewane Christian',
            'role' => 'Expert Structure & BIM',
            'image' => asset('images/team/team.jpg'),
        ],
        [
            'name' => 'Ngono Alice',
            'role' => 'Chargée d\'Études Fluides',
            'image' => asset('images/team/team.jpg'),
        ],
        [
            'name' => 'Mekongo Jean',
            'role' => 'Chef de Chantier Senior',
            'image' => asset('images/team/team.jpg'),
        ],
    ];
@endphp

<div class="flex flex-col gap-6 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-28 pb-20">
    <div class="flex items-center justify-center md:justify-start">
        <span class="text-gcp-primary-color bg-gcp-primary-color/10 text-[13px] font-bold rounded-3xl px-3 py-2">
            Notre équipe
        </span>
    </div>

    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-y-6">
        <h2 class="text-4xl md:text-5xl max-w-2xl capitalize text-foreground font-medium text-start">
            L'excellence technique portée par des <span class="text-gcp-primary-color">experts</span>
        </h2>
        <p class="text-muted-foreground text-start max-w-md">
            Des fondations à la finition, nos spécialistes unissent leurs forces pour garantir la pérennité et la précision de chaque structure que nous bâtissons.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:grid-cols-3 mt-12">
        @foreach($team as $member)
            <div class="card border border-border flex flex-col group overflow-hidden bg-white hover:shadow-md transition-shadow">
                <div class="overflow-hidden min-h-100">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-101" 
                         src="{{ $member['image'] }}" 
                         alt="{{ $member['name'] }}">
                </div>
                <div class="px-3 py-3 flex items-center justify-start gap-3 border border-border">
                    <span class="text-foreground font-bold tracking-tight">
                        {{ $member['name'] }}
                    </span>
                    <span class="size-1.5 rounded-full bg-gcp-primary-color"></span>
                    <span class="text-muted-foreground text-[13px] font-medium">
                        {{ $member['role'] }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>
</div>