@component('mail::message')
# {{ $statusTitle }}

Bonjour **{{ $notifiable->name }}**,

L'administration a traité votre demande concernant le projet **{{ $taskRequest->project->name }}**.

**Détails de la décision :**
* **Tâche :** {{ $taskRequest->title }}
* **Statut :** {{ $statusLabel }}

@if($taskRequest->admin_comment)
**Commentaire de l'admin :**
> {{ $taskRequest->admin_comment }}
@endif

@if($taskRequest->status === 'approuve')
La tâche a été officiellement ajoutée au planning de votre projet.
@endif

@component('mail::button', ['url' => $url])
Consulter mon projet sur CiB Manager
@endcomponent

Merci de votre confiance,<br>
L'équipe **{{ config('app.name') }}**
@endcomponent