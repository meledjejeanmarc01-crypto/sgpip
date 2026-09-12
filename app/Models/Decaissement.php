<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Decaissement extends Model
{
    protected $fillable = ['montant', 'date', 'reference', 'bailleur_id', 'financement_id'];

    protected function casts(): array
    {
        return ['date' => 'date'];
    }

    public function bailleur()
    {
        return $this->belongsTo(Bailleur::class);
    }

    public function financement()
    {
        return $this->belongsTo(Financement::class);
    }
}
