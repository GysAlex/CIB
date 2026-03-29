<x-mail::message>
# Bonjour {{ $adminName }},

L'employé **{{ $submission->user->name }}** vient de soumettre son travail pour la tâche suivante :
**{{ $submission->task->title }}** (Projet : {{ $submission->task->project->name }}).

<x-mail::panel>
**Commentaire de l'employé :** {{ $submission->comment }}
</x-mail::panel>

@if($submission->hasMedia('documents'))
Des documents techniques (AutoCAD, PDF ou rapports) ont été joints à cet envoi.
@endif

<x-mail::button :url="$url">
Examiner et noter le rendu
</x-mail::button>

Cordialement,<br>
{{ config('app.name') }}
</x-mail::message>