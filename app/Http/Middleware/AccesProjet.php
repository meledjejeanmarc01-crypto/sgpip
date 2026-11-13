<?php

namespace App\Http\Middleware;

use App\Models\Financement;
use App\Models\PartiePrenante;
use App\Models\Projet;
use App\Support\FicheVolets;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Un gestionnaire ne modifie que les projets qu'il gère (RG17), ainsi que leurs éléments
 * (activités, tâches, financements, dépenses, documents, rapports, volets de la fiche…).
 *
 * Le projet visé est retrouvé de trois façons :
 *  1. les paramètres de la route (un Projet, ou un élément qui sait de quel projet il dépend) ;
 *  2. les volets de la fiche, qui arrivent par {volet}/{id} et non par un modèle ;
 *  3. les champs du formulaire (projet_id, financement_id, partie_prenante_id).
 *
 * Ne s'applique qu'aux écritures (et aux pages create / edit) ; l'administrateur n'est jamais limité.
 * Le droit de principe « ce rôle peut-il modifier ce module ? » relève de AccesModule.
 */
class AccesProjet
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();
        $nom = (string) $request->route()?->getName();
        $ecriture = ! $request->isMethodSafe() || (bool) preg_match('/\.(create|edit)$/', $nom);

        if (! $user || ! $ecriture || $user->isAdministrateur()) {
            return $next($request);
        }

        foreach ($this->projetsVises($request) as $projet) {
            if (! $user->peutModifierProjet($projet)) {
                abort(403, "Ce projet ne fait pas partie de ceux que vous gérez.");
            }
        }

        return $next($request);
    }

    /** @return \Generator<Projet|null> */
    private function projetsVises(Request $request): \Generator
    {
        // 1. Paramètres de la route
        foreach ($request->route()->parameters() as $parametre) {
            if ($parametre instanceof Projet) {
                yield $parametre;
            } elseif (is_object($parametre) && method_exists($parametre, 'projetAssocie')) {
                yield $parametre->projetAssocie();
            }
        }

        // 2. Volets de la fiche projet : modification / suppression d'une ligne par son identifiant
        $volet = $request->route('volet');
        $id = $request->route('id');
        if (is_string($volet) && $id !== null && ! $request->route('projet')) {
            $def = FicheVolets::get($volet); // 404 si le volet n'existe pas
            $ligne = $def['model']::find($id);
            if ($ligne) {
                $idProjet = $def['scope'] === 'projet'
                    ? $ligne->projet_id
                    : $ligne->{$def['scope']}?->projet_id;
                yield $idProjet ? Projet::find($idProjet) : null;
            }
        }

        // 3. Champs du formulaire
        if (is_scalar($request->input('projet_id')) && $request->filled('projet_id')) {
            yield Projet::find($request->input('projet_id'));
        }
        if (is_scalar($request->input('financement_id')) && $request->filled('financement_id')) {
            yield Financement::find($request->input('financement_id'))?->projetAssocie();
        }
        if (is_scalar($request->input('partie_prenante_id')) && $request->filled('partie_prenante_id')) {
            yield PartiePrenante::find($request->input('partie_prenante_id'))?->projetAssocie();
        }
    }
}
