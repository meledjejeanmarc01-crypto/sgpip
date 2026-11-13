<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Volet de la fiche projet (canevas du Ministère) : table « opportunites_emploi ».
class OpportuniteEmploi extends Model
{
    protected $table = 'opportunites_emploi';

    protected $fillable = ['type_emploi', 'phase', 'nombre_emplois_prevus', 'duree_activite_previsionnelle', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
