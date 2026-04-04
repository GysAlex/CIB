@component('mail::message')
# Nouvelles demandes de prestations

Bonjour,

Le client **{{ $client->name }}** vient de soumettre **{{ $tasks->count() }}** nouveaux besoins pour le projet **{{ $project->name }}**.

### Récapitulatif des tâches demandées :

@foreach($tasks as $task)
* **{{ $task->title }}** * *Urgence :* {{ ucfirst($task->priority) }}
  * *Détail :* {{ $task->description ?? 'Aucune précision' }}
@endforeach

---

@component('mail::button', ['url' => $url])
Accéder aux demandes sur BluePay
@endcomponent

Merci,<br>
L'équipe **{{ config('app.name') }}**
@endcomponent