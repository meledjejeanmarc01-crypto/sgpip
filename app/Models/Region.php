<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Region extends Model
{
    protected $fillable = [
        'district_id',
        'nom',
        'description',
    ];

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class);
    }

    public function departements(): HasMany
    {
        return $this->hasMany(Departement::class);
    }
}