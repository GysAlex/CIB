@php
    $team = [
        [
            'name' => 'AZINWIE Zama Ambe',
            'role' => 'CEO',
            'image' => asset('images/team/team1.jpg'),
        ],
        [
            'name' => 'Honoré MAYOMBOT',
            'role' => 'Integrateur de solutions
                CFA/CFO & Formateur',
            'image' => asset('images/team/team2.jpeg'),
        ],
        [
            'name' => 'FREDERICK NDAM MBAH',
            'role' => 'Ing. Senior Genie Civil 
            Spécialiste structure',
            'image' => asset('images/team/team3.jpeg'),
        ],
        [
            'name' => 'WANDJI PATRICK',
            'role' => 'PROJECTEUR BIM',
            'image' => asset('images/team/team4.jpeg'),
        ],
        [
            'name' => 'Ing. IKENG Pascal',
            'role' => 'Genie Civil BIM Manager CiB',
            'image' => asset('images/team/team5.jpeg'),
        ],
        [
            'name' => 'NGAPOUT Noudine',
            'role' => 'IT Manager',
            'image' => asset('images/team/team6.jpeg'),
        ],
        [
            'name' => 'Ing. SOH Kylian',
            'role' => 'Ingénieur structure',
            'image' => asset('images/team/team7.jpeg'),
        ],
        [
            'name' => 'Ing. NGOH Mac Peace',
            'role' => 'Ingénieur structure',
            'image' => asset('images/team/team8.jpeg'),
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
            Des fondations à la finition, nos spécialistes unissent leurs forces pour garantir la pérennité et la
            précision de chaque structure que nous bâtissons.
        </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:grid-cols-3 mt-12">
        @foreach($team as $member)
            <div
                class="card border border-border flex flex-col group overflow-hidden bg-white hover:shadow-md transition-shadow">
                <div class="overflow-hidden max-h-100">
                    <img class="h-full w-full object-cover transition-transform duration-700 group-hover:scale-101"
                        src="{{ $member['image'] }}" alt="{{ $member['name'] }}">
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
