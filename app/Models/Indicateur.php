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

    // RG12 : quatre cibles trimestrielles par indicateur.
    public function ciblesTrimestrielles()
    {
        return $this->hasMany(CibleTrimestrielle::class)->orderBy('trimestre');
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

    /** Projet dont dépend cet indicateur (via son activité). */
    public function projetAssocie(): ?Projet
    {
        return $this->activite?->projet;
    }
}
