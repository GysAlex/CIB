@component('mail::message')
# Nouveau livrable validé !

Bonjour **{{ $notifiable->name }}**,

Nous avons le plaisir de vous informer qu'un nouveau livrable a été validé par notre équipe administrative pour votre projet **{{ $task->project->name }}**.

**Détails du livrable :**
* **Tâche correspondante :** {{ $task->title }}
* **Validé le :** {{ now()->format('d/m/Y') }}

Vous pouvez dès à présent consulter ce document (ou fichier) directement sur votre tableau de bord.

@component('mail::button', ['url' => $url])
Consulter le bilan du projet
@endcomponent

Une fois sur la page de bilan, descendez jusqu'à la section des tâches terminées pour télécharger vos fichiers.

Merci de votre confiance,<br>
L'équipe **CIB Manager**
@endcomponent