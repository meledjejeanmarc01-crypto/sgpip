<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CritereEvaluation extends Model
{
    protected $table = 'criteres_evaluation';
    protected $fillable = ['critere', 'sous_critere', 'appreciation', 'justification', 'projet_id'];

    public function projet()
    {
        return $this->belongsTo(Projet::class);
    }
}
