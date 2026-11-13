<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// DOCUMENT — cahier : "id, libéllé, source, stratégie, projet_id, utilisateur_id".
class Document extends Model
{
    protected $fillable = [
        'projet_id',
        'type_document_id',
        'titre',
        'source',
        'strategie',
        'type',
        'fichier',
        'description',
        'taille',
        'extension',
        'ajoute_par_id',
    ];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }

    // RG39 : un document ne possède qu'un seul type de document.
    public function typeDocument(): BelongsTo
    {
        return $this->belongsTo(TypeDocument::class);
    }

    // utilisateur_id du cahier des charges.
    public function ajoutePar(): BelongsTo
    {
        return $this->belongsTo(User::class, 'ajoute_par_id');
    }

    /** Projet auquel cet élément est rattaché. */
    public function projetAssocie(): ?Projet
    {
        return $this->projet;
    }
}
