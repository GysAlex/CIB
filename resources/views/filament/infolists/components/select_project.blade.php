<div class="">
    <select 
        onchange="window.location.href = '/admin/set-active-project/' + this.value"
        class="p-3 block w-full rounded-lg border-gray-300 text-sm shadow-sm focus:border-primary-500 focus:ring-primary-500"
    >
        <option value="">-- Sélectionner un Projet --</option>
        @foreach(\App\Models\Project::all() as $project)
            <option value="{{ $project->id }}" {{ session('active_project_id') == $project->id ? 'selected' : '' }}>
                {{ $project->name }}
            </option>
        @endforeach
    </select>
</div>