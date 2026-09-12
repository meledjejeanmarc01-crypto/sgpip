<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Etat extends Model
{
    protected $fillable = ['sigle', 'libelle', 'adresse'];

    public function financements()
    {
        return $this->hasMany(Financement::class);
    }
}
