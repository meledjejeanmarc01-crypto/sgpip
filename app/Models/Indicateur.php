<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicateur extends Model
{
    protected $fillable = ['nom', 'unite', 'situation_reference', 'valeur_cible', 'valeur_realisee', 'date_mesure', 'sources_verification', 'hypothese', 'activite_id', 'resultat_attendu_id'];

    protected function casts(): array
    {
        return ['date_mesure' => 'date'];
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }

    public function resultatAttendu()
    {
        return $this->belongsTo(ResultatAttendu::class);
    }

    public function getTauxRealisationAttribute(): ?float
    {
        if (!$this->valeur_cible) {
            return null;
        }
        return round(($this->valeur_realisee / $this->valeur_cible) * 100, 1);
    }
}
