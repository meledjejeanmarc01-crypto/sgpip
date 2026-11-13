<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Contrôle d'accès par rôle, appliqué à toutes les routes protégées.
 *
 * Le module est le premier segment du nom de la route (« financements.edit » → « financements »).
 * La matrice des droits se trouve dans config/acces.php :
 *  - pages de consultation  → droit « voir »
 *  - pages create / edit et requêtes POST / PUT / PATCH / DELETE → droit « modifier »
 *
 * Un module (ou une route sans nom) absent de la matrice est refusé.
 */
class AccesModule
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403);
        }

        // Compte désactivé pendant que la session était ouverte : déconnexion immédiate.
        if (! $user->actif) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('login')
                ->withErrors(['email' => "Votre compte a été désactivé. Contactez l'administrateur."]);
        }

        $nom = (string) $request->route()?->getName();
        $module = explode('.', $nom)[0];

        $ecriture = ! $request->isMethodSafe() || (bool) preg_match('/\.(create|edit)$/', $nom);

        if ($ecriture) {
            if (! $user->peutModifier($module)) {
                abort(403, $user->isConsultant()
                    ? "Votre profil de consultant ne permet que la consultation."
                    : "Votre profil ne vous autorise pas à modifier ces données.");
            }
        } elseif (! $user->peutVoir($module)) {
            abort(403, "Vous n'avez pas accès à cette page.");
        }

        return $next($request);
    }
}
