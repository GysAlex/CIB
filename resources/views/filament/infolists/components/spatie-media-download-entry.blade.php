<x-dynamic-component
    :component="$getEntryWrapperView()"
    :entry="$entry"
>
    <div {{ $getExtraAttributeBag() }}>
        {{ $getState() }}
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
        @forelse ($getMedia() as $file)
            <div class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 bg-white shadow-sm transition hover:border-primary-500">
                <div class="p-2 bg-primary-50 rounded-lg">
                    @php
                        $icon = match(strtolower($file->extension)) {
                            'pdf' => 'heroicon-o-document-text',
                            'dwg', 'dxf' => 'heroicon-o-pencil-square',
                            'jpg', 'jpeg', 'png' => 'heroicon-o-camera',
                            default => 'heroicon-o-paper-clip'
                        };
                    @endphp
                    <x-filament::icon 
                        :icon="$icon" 
                        class="w-6 h-6 text-primary-600" 
                    />
                </div>

                <div class="flex-1 min-w-0">
                    <p class="text-xs font-semibold text-gray-900 truncate">
                        {{ $file->name }}
                    </p>
                    <p class="text-xs text-gray-500">
                        {{ $file->human_readable_size }}
                    </p>
                </div>

                <a href="{{ route('media.download', ['media' => $file->id]) }}" 
                   class="p-2 text-gray-400 hover:text-primary-600 transition"
                   title="Télécharger">
                    <x-filament::icon icon="heroicon-o-arrow-down-tray" class="w-5 h-5" />
                </a>
            </div>
        @empty
            <p class="text-sm text-gray-500 italic">Aucun document disponible.</p>
        @endforelse
    </div>
</x-dynamic-component>
