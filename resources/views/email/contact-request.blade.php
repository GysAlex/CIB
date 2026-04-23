@component('mail::message')
# Nouvelle demande de contact

Un client potentiel vient d'envoyer une demande via le site web. Voici les détails :

@component('mail::panel')
**Nom :** {{ $data['name'] }}
**Email :** {{ $data['email'] }}
**Téléphone :** {{ $data['phone'] }}
**Type de projet :** {{ $data['projectType'] }}
@endcomponent

**Message :** {{ $data['message'] }}

@component('mail::button', ['url' => 'mailto:' . $data['email']])
Répondre directement
@endcomponent

Merci,<br>
L'automate de notification {{ config('app.name') }}
@endcomponent