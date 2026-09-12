<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Axe extends Model
{
    protected $fillable = ['libelle', 'programme_id'];

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function projets()
    {
        return $this->hasMany(Projet::class);
    }

    public function reformes()
    {
        return $this->hasMany(Reforme::class);
    }
}
