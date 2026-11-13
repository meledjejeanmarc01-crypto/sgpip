<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

// NIVEAU_LOCALISATION — cahier : "id, libellé".
// Les 6 niveaux sont fixes (voir la migration create_niveau_localisations_table) ;
// l'id donne l'ordre hiérarchique : 1 = District ... 6 = Village.
class NiveauLocalisation extends Model
{
    public const DISTRICT = 1;
    public const REGION = 2;
    public const DEPARTEMENT = 3;
    public const COMMUNE = 4;
    public const SOUS_PREFECTURE = 5;
    public const VILLAGE = 6;

    protected $table = 'niveau_localisations';

    protected $fillable = ['libelle'];

    // RG43 : un niveau peut caractériser plusieurs localisations.
    public function localisations(): HasMany
    {
        return $this->hasMany(Localisation::class, 'niveau_id');
    }
}
