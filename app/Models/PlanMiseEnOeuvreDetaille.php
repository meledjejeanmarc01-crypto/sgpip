<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PLANIFICATION du canevas : table « plans_mise_en_oeuvre_detaille ».
class PlanMiseEnOeuvreDetaille extends Model
{
    protected $table = 'plans_mise_en_oeuvre_detaille';

    protected $fillable = ['activite_id', 'annee', 'montant'];

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }
}
