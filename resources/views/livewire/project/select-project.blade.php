<div class="flex items-center">
        <form wire:submit="create">
        {{ $this->form }}
    </form>
    
    <x-filament-actions::modals />
</div>