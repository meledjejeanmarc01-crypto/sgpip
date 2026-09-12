<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bailleur extends Model
{
    protected $fillable = ['nom', 'sigle', 'contact', 'type_bailleur_id'];

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
