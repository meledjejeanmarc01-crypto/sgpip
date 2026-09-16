<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EcheancierAeCp extends Model
{
    protected $table = 'echeanciers_ae_cp';
    protected $fillable = ['annee_lf', 'montant_ae', 'montant_cp', 'marche_id'];

    public function marche()
    {
        return $this->belongsTo(Marche::class);
    }
}
