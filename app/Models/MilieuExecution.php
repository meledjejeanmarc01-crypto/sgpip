<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// MILIEU D'EXECUTION — cahier : "id, catégorie (rural, urbain, péri-urbain ou inter-urbain)".
// RG37 : un milieu d'exécution est rattaché à un seul projet.
class MilieuExecution extends Model
{
    protected $table = 'milieux_execution';
    protected $fillable = ['categorie', 'projet_id'];

    public function projet(): BelongsTo
    {
        return $this->belongsTo(Projet::class);
    }
}
