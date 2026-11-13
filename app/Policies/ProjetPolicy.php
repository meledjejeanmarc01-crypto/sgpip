<?php

namespace App\Policies;

use App\Models\Projet;
use App\Models\User;

class ProjetPolicy
{
    public function create(User $user): bool
    {
        return $user->hasRole(['administrateur', 'gestionnaire_projet']);
    }

    public function update(User $user, Projet $projet): bool
    {
        return $user->peutModifierProjet($projet);
    }

    public function delete(User $user, Projet $projet): bool
    {
        return $user->peutModifierProjet($projet);
    }
}