<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class District extends Model
{
    protected $fillable = [
        'nom',
        'description',
    ];

    public function regions(): HasMany
    {
        return $this->hasMany(Region::class);
    }
}