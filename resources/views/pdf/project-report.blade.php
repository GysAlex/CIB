<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Rapport de Projet</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; font-size: 12px; }
        .header { text-align: center; border-bottom: 2px solid #D4AF37; padding-bottom: 10px; margin-bottom: 20px; }
        .project-title { color: #1a1a1a; font-size: 20px; text-transform: uppercase; }
        .section-title { background: #f4f4f4; padding: 5px 10px; font-weight: bold; margin-top: 20px; border-left: 4px solid #D4AF37; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #eee; padding: 8px; text-align: left; }
        th { background-color: #fafafa; }
        .footer { margin-top: 50px; }
        .signature-box { width: 45%; display: inline-block; border: 1px solid #ccc; height: 100px; padding: 10px; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="project-title">{{ $project->name }}</h1>
        <p>Bilan Officiel des Livrables - Généré le {{ $date }}</p>
    </div>

    <div class="section-title">Informations Générales</div>
    <table>
        <tr>
            <th>Client</th><td>{{ $project->client->name ?? 'N/A' }}</td>
            <th>Localisation</th><td>{{ $project->location ?? 'Cameroun' }}</td>
        </tr>
    </table>

    <div class="section-title">État d'Avancement des Missions</div>
    <table>
        <thead>
            <tr>
                <th>Mission / Tâche</th>
                <th>Statut</th>
                <th>Date Validation</th>
            </tr>
        </thead>
        <tbody>
            @foreach($project->tasks as $task)
                <tr>
                    <td>{{ $task->title }}</td>
                    <td>{{ strtoupper($task->status) }}</td>
                    <td>{{ $task->updated_at->format('d/m/Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="section-title">Index des Livrables Archivés</div>
    <ul>
        @foreach($project->tasks as $task)
            @foreach($task->submissions as $submission)
                @foreach($submission->media as $media)
                    <li>{{ $media->name }} ({{ $media->extension }}) - Rendu par {{ $submission->user->name }}</li>
                @endforeach
            @endforeach
        @endforeach
    </ul>

    <div class="footer">
        <div class="signature-box">
            <strong>Pour l'Entreprise</strong><br><small>(Cachet et Signature)</small>
        </div>
        <div class="signature-box" style="float: right;">
            <strong>Bon pour Réception (Client)</strong><br><small>(Date et Signature)</small>
        </div>
    </div>
</body>
</html>