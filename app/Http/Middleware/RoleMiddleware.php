<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Autorise l'accès uniquement aux utilisateurs possédant l'un des rôles indiqués.
     * Utilisation dans les routes : ->middleware('role:administrateur,gestionnaire_projet')
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if (!$user || (!empty($roles) && !in_array($user->role, $roles, true))) {
            abort(403, "Vous n'avez pas les droits nécessaires pour accéder à cette page.");
        }

        return $next($request);
    }
}
