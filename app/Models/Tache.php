<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tache extends Model
{
    protected $fillable = ['intitule', 'description', 'date_debut', 'date_fin', 'activite_id', 'depense_id'];

    protected function casts(): array
    {
        return ['date_debut' => 'date', 'date_fin' => 'date'];
    }

    public function activite()
    {
        return $this->belongsTo(Activite::class);
    }

    public function depense()
    {
        return $this->belongsTo(Depense::class);
    }
}
