<div class="space-y-6">
    {{-- Barre d'outils de l'explorateur --}}
    <div class="flex justify-between items-center px-2">
        <h3 class="text-sm font-semibold text-gray-600 uppercase tracking-wider">Documents validés</h3>
        
        @if($files->isNotEmpty())
            <x-filament::button 
                wire:click="downloadAll" 
                icon="heroicon-m-archive-box-arrow-down" 
                color="gray" 
                size="sm"
                outline
            >
                Tout télécharger (.zip)
            </x-filament::button>
        @endif
    </div>

    @if($files->isEmpty())
        <div class="flex flex-col items-center justify-center p-12 border-2 border-dashed border-gray-200 rounded-xl dark:border-gray-800">
            <x-heroicon-o-document-magnifying-glass class="w-12 h-12 text-gray-300 mb-2" />
            <p class="text-gray-500 italic">Aucun fichier archivé.</p>
        </div>
    @else
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-2">
            @foreach($files as $file)
                <div class="flex flex-col bg-white dark:bg-gray-900 border border-gray-200 dark:border-gray-700 rounded-lg hover:border-primary-500 transition-colors overflow-hidden group">
                    
                    {{-- Zone Icône Réduite --}}
                    <div class="h-24 flex items-center justify-center bg-gray-50 dark:bg-gray-800/50 border-b border-gray-100 dark:border-gray-800">
                        @php
                            $icon = match($file->extension) {
                                'pdf' => ['icon' => 'heroicon-o-document-text', 'color' => 'text-red-500'],
                                'dwg', 'dxf' => ['icon' => 'heroicon-o-variable', 'color' => 'text-blue-500'],
                                'jpg', 'png', 'jpeg' => ['icon' => 'heroicon-o-photo', 'color' => 'text-green-500'],
                                default => ['icon' => 'heroicon-o-document', 'color' => 'text-gray-400'],
                            };
                        @endphp
                        <x-dynamic-component :component="$icon['icon']" class="w-8 h-8 {{ $icon['color'] }}" />
                    </div>

                    {{-- Détails --}}
                    <div class="p-3 flex-grow">
                        <p class="text-xs font-semibold truncate text-gray-700 dark:text-gray-300 mb-1" title="{{ $file->name }}">
                            {{ $file->name }}
                        </p>
                        <div class="flex justify-between items-center text-[10px] text-gray-400 uppercase">
                            <span>{{ number_format($file->size / 1024 / 1024, 2) }} MB</span>
                            <span class="bg-gray-100 dark:bg-gray-800 px-1 rounded">{{ $file->extension }}</span>
                        </div>
                    </div>

                    {{-- Barre d'actions discrète --}}
                    <div class="flex border-t border-gray-100 dark:border-gray-800">
                        <button 
                            wire:click="download({{ $file->id }})"
                            class="flex-1 p-2 hover:bg-gray-50 dark:hover:bg-gray-800 text-gray-500 border-r border-gray-100 dark:border-gray-800 transition-colors"
                            title="Télécharger"
                        >
                            <x-heroicon-m-arrow-down-tray class="w-4 h-4 mx-auto" />
                        </button>
                        
                        {{-- Utilisation de l'action Filament pour les détails
                        <button wire:click="mountAction('viewDetails, { record: {{ $file->id }}}')" class="flex-1 flex justify-center items-center hover:bg-gray-50 dark:hover:bg-gray-800 transition-colors">
                            test
                        </button> --}}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <x-filament-actions::modals />
</div>