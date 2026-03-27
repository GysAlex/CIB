<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceProjectContext
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Si l'URL contient un projet, on l'enregistre en session
        if ($request->has('project')) {
            session(['active_project_id' => $request->query('project')]);
        }

        // 2. Si l'URL n'a pas de projet MAIS que la session en a un,
        // on force le paramètre par défaut pour les futurs liens
        if (!$request->has('project') && session()->has('active_project_id')) {
            \Illuminate\Support\Facades\URL::defaults([
                'project' => session('active_project_id')
            ]);
        }

        return $next($request);
    }
}
