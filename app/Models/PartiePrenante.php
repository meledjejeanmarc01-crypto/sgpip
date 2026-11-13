<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// PARTIE_PRENANTE — cahier : "id, libéllé, sig, projet_id, Type partie prenante_id".
class PartiePrenante extends Model
{
    protected $table = 'parties_prenantes';

    protected $fillable = ['libelle', 'role', 'sig', 'type_partie_prenante_id', 'projet_id'];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    // RG16 : une partie prenante regroupe plusieurs acteurs.
    public function acteurs()
    {
        return $this->hasMany(Acteur::class);
    }

    // RG51 : une partie prenante appartient à un seul type de partie prenante.
    public function typePartiePrenante(): BelongsTo
    {
        return $this->belongsTo(TypePartiePrenante::class);
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
