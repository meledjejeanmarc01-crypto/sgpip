<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Departement extends Model
{
    protected $fillable = [
        'region_id',
        'nom',
        'description',
    ];

    public function region(): BelongsTo
    {
        return $this->belongsTo(Region::class);
    }

    public function sousPrefectures(): HasMany
    {
        return $this->hasMany(SousPrefecture::class);
    }

    public function communes(): HasMany
    {
        return $this->hasMany(Commune::class);
    }
}