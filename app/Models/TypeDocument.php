<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// TYPE_DOCUMENT — cahier : "id, libéllé". RG39.
class TypeDocument extends Model
{
    protected $table = 'types_document';
    protected $fillable = ['libelle'];

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}
