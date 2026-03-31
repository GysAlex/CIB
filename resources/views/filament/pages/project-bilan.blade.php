<x-filament-panels::page>

    <div class="flex items-center justify-center">
        <form wire:submit.prevent="" class="w-fit mx-auto flex flex-wrap">
            {{ $this->form }}
        </form>
    </div>

    {{-- Zone de l'Explorateur de Fichiers (Étape suivante) --}}
    <div class="bg-gray-200 p-3">
        @if($project)
            <livewire:project-file-explorer :projectId="$project" :taskId="$task" :key="$project . '-' . $task" />
        @else
            <div
                class="flex flex-col items-center justify-center p-12 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl dark:bg-gray-900 dark:border-gray-800">
                <x-heroicon-o-folder-open class="w-16 h-16 text-gray-300 mb-4" />
                <p class="text-gray-500 text-lg">Sélectionnez un projet pour explorer les livrables validés.</p>
            </div>
        @endif
    </div>
</x-filament-panels::page>