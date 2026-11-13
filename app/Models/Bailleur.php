<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
    protected $fillable = ['nom', 'sigle', 'contact', 'type_bailleur_id', 'pays_etranger_id'];

    // Un pays étranger peut correspondre à plusieurs bailleurs ; un bailleur est rattaché à un seul pays.
    public function paysEtranger()
    {
        return $this->belongsTo(PaysEtranger::class, 'pays_etranger_id');
    }

    public function typeBailleur()
    {
        return $this->belongsTo(TypeBailleur::class, 'type_bailleur_id');
    }

    public function financements()
    {
        return $this->hasMany(Financement::class);
    }

    public function decaissements()
    {
        return $this->hasMany(Decaissement::class);
    }
}
