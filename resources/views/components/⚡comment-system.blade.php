<?php

use Livewire\Component;
use Illuminate\Validation\Rule;
use Filament\Notifications\Notification;
use App\Models\User;

new class extends Component {
    public $guest_name = '';
    public $guest_email = '';
    public $content = '';
    public $model;

    public function mount($model)
    {
        $this->model = $model;
        
    }
    public function rules(): array
    {

        return [
            'guest_name' => [Rule::requiredIf(!!!Auth::user()), 'min:2'],
            'guest_email' => 'nullable|email',
            'content' => 'required|min:5|max:500'
        ];
    }

    public function messages(): array
    {
        return [
            'guest_name.required' => "le nom est obligatoire",
            'content.required' => "le message est obligatoire",
            'content.min' => "le message est trop court",
            'content.max' => "le message est trop long",
            'guest_name' => "le nom est trop court",
            'guest_email.email' => "ce champ doit être une email valide"
        ];
    }

    public function postComment()
    {
        $this->validate();

        $this->model->comments()->create([
            'user_id' => auth()->id(), // Sera null si invité
            'guest_name' => auth()->check() ? null : $this->guest_name,
            'guest_email' => auth()->check() ? null : $this->guest_email,
            'content' => $this->content,
            'is_approved' => false, // Recommandé pour les invités (modération)
        ]);

        $this->reset(['content', 'guest_name', 'guest_email']);
        session()->flash('message', 'Votre commentaire est en attente de modération.');

        Notification::make()
        ->title('Nouveau commentaire reçu')
        ->body('Vous devez modére ce commentaire')
        ->sendToDatabase($this->model->user);

    }
};
?>
<div class="pb-15">
    <h3 class="text-2xl font-bold text-foreground mb-8">
        Commentaires ({{ $model->comments()->approved()->count() }})
    </h3>

    <form wire:submit.prevent="postComment" class="mb-12 space-y-4">
        @if(!auth()->check())
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <input wire:model="guest_name" type="text" placeholder="Votre nom *"
                    class="w-full p-3 bg-secondary/20 border {{ $errors->has('content') ? 'border-red-500' : 'border-border' }}  focus:border-gcp-primary-color outline-none">
                <input wire:model="guest_email" type="email" placeholder="Votre email (optionnel)"
                    class="w-full p-3 bg-secondary/20 border border-border  focus:border-gcp-primary-color outline-none">
            </div>
            <div class="flex gap-2">
                @error('guest_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
            </div>
        @endif

        <textarea wire:model="content" placeholder="Posez votre question technique..."
            class="w-full p-4 bg-secondary/20 border {{ $errors->has('content') ? 'border-red-500' : 'border-border' }} focus:border-gcp-primary-color outline-none transition-all"
            rows="4"></textarea>
        @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror

        <div class="flex flex-col md:flex-row items-start justify-start md:items-center gap-3">
            
            @if(session('message'))
                <div class="text-green-600 test-sm">
                    {{ session('message') }}
                </div>
            @endif
            <button type="submit"
                class="px-4 py-3 bg-gcp-primary-color text-white font-bold text-sm rounded-2xl hover:shadow-lg transition-all">
                Envoyer mon commentaire
            </button>
        </div>
    </form>

    <div class="space-y-8 border-l pl-4 border-gcp-secondary-color/50">
        @foreach($model->comments()->approved()->get() as $comment)
            <div class="flex gap-4 items-center">
                <div
                    class="size-10 shrink-0 bg-gcp-primary-color rounded-full flex items-center justify-center text-white font-bold text-xs">
                    {{ $comment->user ? substr($comment->user->name, 0, 2) : substr($comment->guest_name, 0, 2) }}
                </div>
                <div class="flex flex-col gap-1">
                    <div class="flex items-center gap-3">
                        <span class="font-bold text-foreground">
                            {{ $comment->user ? $comment->user->name : $comment->guest_name }}
                        </span>
                        @if(!$comment->user)
                            <span class="text-[10px] bg-gray-100 px-2 py-0.5 rounded text-gray-500">Visiteur</span>
                        @endif
                        <span
                            class="text-[10px] text-muted-foreground uppercase tracking-widest">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-muted-foreground leading-relaxed">
                        {{ $comment->content }}
                    </p>
                </div>
            </div>
        @endforeach
    </div>
</div>