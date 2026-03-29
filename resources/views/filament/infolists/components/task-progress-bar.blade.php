@php
    $start = $record->created_at;
    $end = $record->deadline;
    $now = now();

    $totalDays = $start->diffInDays($end) ?: 1; 
    $elapsedDays = $start->diffInDays($now);

    $diff = $start->diffInDays($end);

    $percentage = min(100, max(0, round(($elapsedDays / $totalDays) * 100)));

    $color = $percentage < 50 ? '#22c55e' : ($percentage < 85 ? '#f59e0b' : '#ef4444');
@endphp
<x-dynamic-component :component="$getEntryWrapperView()" :entry="$entry">
    <div {{ $getExtraAttributeBag() }}>
        {{ $getState() }}
    </div>
    <div class="space-y-2 mb-3">
        <div class="flex justify-between text-xs font-medium text-gray-500">
            <span>Début : {{ $start->translatedFormat(' d F Y') }}</span>
            <span>{{ $percentage }}% du temps écoulé</span>
            @if ($end)
                <span>Fin : {{ $end->translatedFormat(' d F Y') }}</span>
            @endif
            
        </div>

        <div class="w-full bg-gray-200 rounded-full h-2.5 relative flex flex-col dark:bg-gray-700">
            <div class="h-2.5 rounded-full absolute transition-all duration-500"
                style="width: {{ $percentage }}%; background-color: {{ $color }};">
            </div>
            <div class="text-xs text-end mt-4">
                {{ floor($diff) }} 
                @if( $diff > 1  )
                    jours restants
                @else
                    jour restant
                @endif

            </div>
        </div>
    </div>
</x-dynamic-component>