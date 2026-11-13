<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

// OBJECTIF SPECIFIQUE — cahier : "id, libéllé, description". RG38 : rattaché à un seul projet.
class ObjectifSpecifique extends Model
{
    protected $table = 'objectifs_specifiques';

    protected $fillable = ['libelle', 'type_objectif', 'description', 'projet_id'];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    // RG30 : un objectif spécifique peut viser plusieurs résultats attendus.
    public function resultatsAttendus(): HasMany
    {
        return $this->hasMany(ResultatAttendu::class);
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
