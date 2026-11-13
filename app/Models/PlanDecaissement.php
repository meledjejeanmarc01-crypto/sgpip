<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// Feuille PLANIFICATION du canevas : table « plans_decaissement ».
class PlanDecaissement extends Model
{
    protected $table = 'plans_decaissement';

    protected $fillable = ['financement_id', 'annee', 'montant'];

    public function financement()
    {
        return $this->belongsTo(Financement::class);
    }
}
