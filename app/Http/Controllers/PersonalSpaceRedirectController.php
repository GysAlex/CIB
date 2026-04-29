<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PersonalSpaceRedirectController extends Controller
{
    public function redirection()
    {
        if (Auth::user()->hasRole('admin') || Auth::user()->hasRole('staff')) {
            return redirect(route('filament.admin.pages.project-dashboard'));
        }
        else if(Auth::user()->hasRole('client')){
            return redirect(route('filament.client.pages.dashboard'));
        }
        else if (Auth::user()->hasRole('employee')) {
            return redirect(route('filament.employee.pages.dashboard'));   
        }

        return redirect(route('home'));
    }
}
