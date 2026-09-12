<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ZoneLocalisation extends Model
{
    protected $table = 'zones_localisation';
    protected $fillable = ['type', 'libelle', 'parent_id', 'latitude', 'longitude'];

    public function parent()
    {
        return $this->belongsTo(ZoneLocalisation::class, 'parent_id');
    }

    public function enfants()
    {
        return $this->hasMany(ZoneLocalisation::class, 'parent_id');
    }

    public function projets()
    {
        return $this->hasMany(Projet::class, 'zone_localisation_id');
    }
}
