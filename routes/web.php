<?php

use App\Models\Role;
use App\Models\TaskTemplate;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/attachRole', function(){
    $user = User::where('id', 1)->first();

    $user->roles()->sync(Role::where('name', 'admin')->first());

    echo "everything was good !";
});

// Route::get('/admin/set-active-project/{id}', function ($id) {
//     if ($id == 0) {
//         session()->forget('active_project_id');
//     } else {
//         session(['active_project_id' => $id]);
//     }
    
//     return back()->with('success', 'Projet actif mis à jour');
// })->middleware(['auth']);


Route::post('/filament/project/switch', function (Request $request) {
    $projectId = $request->input('project_id');
    
    if ($projectId) {
        session(['active_project_id' => (int) $projectId]);
    } else {
        session()->forget('active_project_id');
    }
    
    return back();
})->middleware(['auth'])->name('filament.project.switch');



Route::get('/tasks', function(){
    $task = TaskTemplate::findOrFail(2);

    return $task->parent;
});