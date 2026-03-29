<x-mail::message>
# Bonjour {{ $user->name }},

Une nouvelle mission vient de vous être assignée dans le cadre du projet **{{ $task->project->name }}**.

## Détails de la mission :
**Intitulé :** {{ $task->title }}  
**Échéance :** {{ $task->deadline?->format('d/m/Y') ?? 'Non définie' }}

### Description & Instructions :
{{ $task->description }}

@if($task->getMedia('documents')->count() > 0)
<x-mail::panel>
    Des documents techniques (plans, notes de calcul) sont joints à cette tâche sur votre plateforme.
</x-mail::panel>
@endif

<x-mail::button :url="$url" color="success">
Accéder à la tâche et soumettre un rendu
</x-mail::button>

Cordialement,<br>
L'administration de {{ config('app.name') }}
</x-mail::message>