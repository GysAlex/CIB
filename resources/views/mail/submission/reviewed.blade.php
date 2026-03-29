<x-mail::message>
# Bonjour {{ $submission->user->name }},

L'administration a terminé l'examen de votre rendu pour la mission :  
**{{ $submission->task->title }}**

@if($isApproved)
## Félicitations, votre travail a été validé !
<x-mail::panel>
**Note de qualité :** {{ $feedback->score }}/5  
**Commentaire :** {{ $feedback->comment }}
</x-mail::panel>
C'est du bon travail. Vous pouvez maintenant passer à vos autres tâches en cours.
@else
## Des corrections sont nécessaires
<x-mail::panel>
**Observations de l'examinateur :** {{ $feedback->comment }}
</x-mail::panel>
Merci de prendre en compte ces remarques et de soumettre une nouvelle version de votre travail dès que possible.
@endif

<x-mail::button :url="$url" :color="$isApproved ? 'success' : 'primary'">
Voir les détails sur la plateforme
</x-mail::button>

Cordialement,<br>
{{ config('app.name') }}
</x-mail::message>