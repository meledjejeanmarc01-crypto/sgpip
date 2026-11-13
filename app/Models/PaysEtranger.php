<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// PAYS_ETRANGER — RG48.
class PaysEtranger extends Model
{
    protected $table = 'pays_etrangers';
    protected $fillable = ['libelle', 'code_iso'];

    public function zonesExecution(): HasMany
    {
        return $this->hasMany(ZoneLocalisation::class, 'pays_etranger_id');
    }
}
