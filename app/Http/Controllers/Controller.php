<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Vérifie que l'utilisateur peut modifier le projet indiqué
     * (utile quand le projet arrive par un formulaire et non par l'URL).
     */
    protected function autoriserProjet(?int $projetId): void
    {
        if ($projetId) {
            $this->authorize('update', Projet::findOrFail($projetId));
        }
    }
}
