<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// ACTION_PND — cahier : "id, libelle, description". RG40 : une action peut concerner
// plusieurs projets ; un projet n'est rattaché qu'à une seule action.
class ActionPnd extends Model
{
    protected $table = 'actions_pnd';
    protected $fillable = ['libelle', 'description'];

    public function projets(): HasMany
    {
        return $this->hasMany(Projet::class, 'action_pnd_id');
    }
}
