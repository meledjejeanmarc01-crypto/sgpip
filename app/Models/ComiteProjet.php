<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComiteProjet extends Model
{
    protected $table = 'comites_projet';
    protected $fillable = ['type', 'role', 'composition', 'observation', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
