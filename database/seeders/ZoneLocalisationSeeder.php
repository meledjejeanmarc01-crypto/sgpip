<?php

namespace Database\Seeders;

use App\Models\Localisation;
use App\Models\NiveauLocalisation;
use Illuminate\Database\Seeder;

// Hiérarchie géographique (table "localisations") :
// District -> Région -> Département -> Commune -> Sous-préfecture -> Village (RG43 à RG45).
// Les zones d'exécution sont créées ensuite (ProjetDemoSeeder) et rattachées à ces localisations.
// NB : les 31 régions administratives de Côte d'Ivoire sont ici regroupées sous un district
// générique "Régions de l'intérieur" (donnée de démonstration simplifiée) ; le regroupement
// précis par district peut être affiné ensuite depuis la page "Localisation géographique".
class ZoneLocalisationSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(NiveauLocalisationSeeder::class);

        // --- District Autonome d'Abidjan + ses communes ---
        $districtAbidjan = $this->localisation("District Autonome d'Abidjan", NiveauLocalisation::DISTRICT);
        $regionAbidjan = $this->localisation('Abidjan', NiveauLocalisation::REGION, $districtAbidjan);
        $departementAbidjan = $this->localisation('Abidjan', NiveauLocalisation::DEPARTEMENT, $regionAbidjan);

        $communesAbidjan = [
            'Abobo', 'Adjamé', 'Attécoubé', 'Bingerville', 'Cocody', 'Koumassi',
            'Marcory', 'Le Plateau', 'Port-Bouët', 'Songon', 'Treichville', 'Yopougon',
        ];
        foreach ($communesAbidjan as $libelle) {
            $this->localisation($libelle, NiveauLocalisation::COMMUNE, $departementAbidjan);
        }

        // --- District Autonome de Yamoussoukro ---
        $districtYamoussoukro = $this->localisation('District Autonome de Yamoussoukro', NiveauLocalisation::DISTRICT);
        $this->localisation('Yamoussoukro', NiveauLocalisation::REGION, $districtYamoussoukro);

        // --- Les 31 régions administratives restantes ---
        $districtRegions = $this->localisation("Régions de l'intérieur", NiveauLocalisation::DISTRICT);

        $regions = [
            'Agnéby-Tiassa', 'Bafing', 'Bagoué', 'Bélier', 'Béré', 'Bounkani', 'Cavally',
            'Folon', 'Gbêkê', 'Gbôklé', 'Gôh', 'Gontougo', 'Grands-Ponts', 'Guémon',
            'Hambol', 'Haut-Sassandra', 'Iffou', 'Indénié-Djuablin', 'Kabadougou', 'La Mé',
            'Lôh-Djiboua', 'Marahoué', 'Moronou', 'Nawa', 'Nzi', 'Poro', 'San-Pédro',
            'Sud-Comoé', 'Tchologo', 'Tonkpi', 'Worodougou',
        ];
        foreach ($regions as $libelle) {
            $this->localisation($libelle, NiveauLocalisation::REGION, $districtRegions);
        }
    }

    private function localisation(string $libelle, int $niveauId, ?Localisation $parent = null): Localisation
    {
        $colonneDuParent = $niveauId > 1 ? Localisation::niveauVersColonne($niveauId - 1) : null;

        $existante = Localisation::where('niveau_id', $niveauId)
            ->where('libelle', $libelle)
            ->when($colonneDuParent, fn ($q) => $q->where($colonneDuParent, $parent?->id))
            ->first();

        return $existante ?? Localisation::creerSous($niveauId, $parent, ['libelle' => $libelle]);
    }
}
