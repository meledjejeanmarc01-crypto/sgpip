<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Volet de la fiche projet (canevas du Ministère) : table « marches ».
class Marche extends Model
{
    protected $table = 'marches';

    protected $fillable = ['objet', 'etat', 'duree', 'cout', 'montant_engage', 'montant_liquide', 'montant_paye', 'restes_a_engager', 'charges_a_payer', 'projet_id',
        'engagements_anterieurs_i1', 'engagements_anterieurs_i2', 'liquidations_j1', 'liquidations_j2'];

    // Fiche AE-CP : cumuls recalculés à chaque enregistrement à partir des montants antérieurs.
    //   engagements cumulés (i) = i1 + i2 ; restes à engager (AE) = coût - i
    //   liquidations cumulées (j) = j1 + j2 ; charges à payer = j - paiements cumulés (k)
    protected static function booted(): void
    {
        static::saving(function (Marche $m) {
            if (! is_null($m->engagements_anterieurs_i1) || ! is_null($m->engagements_anterieurs_i2)) {
                $m->montant_engage = (float) $m->engagements_anterieurs_i1 + (float) $m->engagements_anterieurs_i2;
                $m->restes_a_engager = (float) $m->cout - (float) $m->montant_engage;
            }
            if (! is_null($m->liquidations_j1) || ! is_null($m->liquidations_j2)) {
                $m->montant_liquide = (float) $m->liquidations_j1 + (float) $m->liquidations_j2;
                $m->charges_a_payer = (float) $m->montant_liquide - (float) $m->montant_paye;
            }
        });
    }

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }

    public function echeanciers()
    {
        return $this->hasMany(EcheancierAeCp::class);
    }
}
