<html>
<head>
    <style>
        body { font-family: sans-serif; color: #333; }
        .header { text-align: center; border-bottom: 2px solid #0056b3; padding-bottom: 10px; }
        .stats-container { margin: 20px 0; display: table; width: 100%; }
        .stat-box { display: table-cell; padding: 10px; background: #f4f4f4; border: 1px solid #ddd; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #eee; padding: 10px; text-align: left; font-size: 12px; }
        th { background-color: #0056b3; color: white; }
        .badge { padding: 3px 7px; border-radius: 10px; font-size: 10px; }
        .success { background: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Bilan de Performance Mensuel</h1>
        <p><strong>Employé :</strong> {{ $employee->name }} | <strong>Période :</strong> {{ $period }}</p>
    </div>

    <div class="stats-container">
        <div class="stat-box"><strong>{{ $stats['total'] }}</strong><br>Soumissions</div>
        <div class="stat-box"><strong>{{ $stats['validated'] }}</strong><br>Validées</div>
        <div class="stat-box"><strong>{{ $stats['avg_version'] }}</strong><br>Versions/Tâche</div>
    </div>

    <h3>Détail des activités</h3>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Projet</th>
                <th>Tâche</th>
                <th>Version</th>
                <th>Statut</th>
            </tr>
        </thead>
        <tbody>
            @foreach($submissions as $sub)
            <tr>
                <td>{{ $sub->created_at->format('d/m/Y') }}</td>
                <td>{{ $sub->task->project->name }}</td>
                <td>{{ $sub->task->title }}</td>
                <td>V{{ $sub->version }}</td>
                <td>{{ $sub->status }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>