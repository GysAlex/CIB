<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/attachRole', function(){
    $user = User::where('id', 1)->first();

    $user->roles()->sync(Role::where('name', 'admin')->first());

    echo "everything was good !";
});