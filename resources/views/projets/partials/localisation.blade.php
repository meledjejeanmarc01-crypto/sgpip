{{-- LOCALISATION DU PROJET --}}
<div class="card border-0 shadow-sm mb-4">

    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-geo-alt"></i>
            Localisation du projet
        </h5>
    </div>

    <div class="card-body">

        <div class="row g-3">

            {{-- DISTRICT --}}
            <div class="col-md-6">

                <label for="district_id" class="form-label">
                    District
                </label>

                <select
                    id="district_id"
                    class="form-select"
                >
                    <option value="">
                        -- Sélectionner un district --
                    </option>

                    @foreach($districts as $district)

                        <option value="{{ $district->id }}">
                            {{ $district->nom }}
                        </option>

                    @endforeach
                </select>

            </div>


            {{-- REGION --}}
            <div class="col-md-6">

                <label for="region_id" class="form-label">
                    Région
                </label>

                <select
                    id="region_id"
                    class="form-select"
                    disabled
                >
                    <option value="">
                        -- Sélectionner une région --
                    </option>
                </select>

            </div>


            {{-- DEPARTEMENT --}}
            <div class="col-md-6">

                <label for="departement_id" class="form-label">
                    Département
                </label>

                <select
                    id="departement_id"
                    class="form-select"
                    disabled
                >
                    <option value="">
                        -- Sélectionner un département --
                    </option>
                </select>

            </div>


            {{-- SOUS-PREFECTURE --}}
            <div class="col-md-6">

                <label for="sous_prefecture_id" class="form-label">
                    Sous-préfecture
                </label>

                <select
                    id="sous_prefecture_id"
                    class="form-select"
                    disabled
                >
                    <option value="">
                        -- Sélectionner une sous-préfecture --
                    </option>
                </select>

            </div>


            {{-- COMMUNE --}}
            <div class="col-md-6">

                <label for="commune_id" class="form-label">
                    Commune
                </label>

                <select
                    id="commune_id"
                    class="form-select"
                    disabled
                >
                    <option value="">
                        -- Sélectionner une commune --
                    </option>
                </select>

            </div>


            {{-- LOCALITE --}}
            <div class="col-md-6">

                <label for="localite_id" class="form-label">
                    Localité
                </label>

                <select
                    name="localite_id"
                    id="localite_id"
                    class="form-select"
                    disabled
                >
                    <option value="">
                        -- Sélectionner une localité --
                    </option>
                </select>

                @error('localite_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror

            </div>

        </div>


        {{-- COORDONNEES --}}
        <div
            id="coordonnees"
            class="alert alert-info mt-4 d-none"
        >

            <strong>
                <i class="bi bi-geo-alt-fill"></i>
                Coordonnées GPS
            </strong>

            <div class="mt-2">
                Latitude :
                <span id="latitude">-</span>
            </div>

            <div>
                Longitude :
                <span id="longitude">-</span>
            </div>

        </div>

    </div>

</div>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const districtSelect = document.getElementById('district_id');
    const regionSelect = document.getElementById('region_id');
    const departementSelect = document.getElementById('departement_id');
    const sousPrefectureSelect = document.getElementById('sous_prefecture_id');
    const communeSelect = document.getElementById('commune_id');
    const localiteSelect = document.getElementById('localite_id');

    const coordonnees = document.getElementById('coordonnees');
    const latitude = document.getElementById('latitude');
    const longitude = document.getElementById('longitude');

    // Localisation déjà enregistrée sur le projet (mode édition uniquement)
    const existant = {
        district_id: {{ (isset($projet) && $projet?->localite) ? ($projet->localite->commune->departement->region->district->id ?? 'null') : 'null' }},
        region_id: {{ (isset($projet) && $projet?->localite) ? ($projet->localite->commune->departement->region->id ?? 'null') : 'null' }},
        departement_id: {{ (isset($projet) && $projet?->localite) ? ($projet->localite->commune->departement->id ?? 'null') : 'null' }},
        commune_id: {{ (isset($projet) && $projet?->localite) ? ($projet->localite->commune->id ?? 'null') : 'null' }},
        localite_id: {{ (isset($projet) && $projet?->localite) ? $projet->localite->id : 'null' }},
    };


    /*
    |--------------------------------------------------------------------------
    | Fonction générique pour charger les données
    |--------------------------------------------------------------------------
    */

    async function chargerDonnees(url, select, texte) {

        select.innerHTML = `
            <option value="">
                Chargement...
            </option>
        `;

        select.disabled = true;

        try {

            const response = await fetch(url);

            if (!response.ok) {
                throw new Error('Erreur HTTP ' + response.status);
            }

            const data = await response.json();

            select.innerHTML = `
                <option value="">
                    ${texte}
                </option>
            `;

            data.forEach(function (element) {

                const option = document.createElement('option');

                option.value = element.id;
                option.textContent = element.nom;

                select.appendChild(option);

            });

            select.disabled = data.length === 0;

        } catch (error) {

            console.error(error);

            select.innerHTML = `
                <option value="">
                    Erreur de chargement
                </option>
            `;

            select.disabled = true;
        }
    }


    /*
    |--------------------------------------------------------------------------
    | DISTRICT → REGION
    |--------------------------------------------------------------------------
    */

    districtSelect.addEventListener('change', function () {

        const districtId = this.value;

        regionSelect.innerHTML = `
            <option value="">
                -- Sélectionner une région --
            </option>
        `;

        departementSelect.innerHTML = `
            <option value="">
                -- Sélectionner un département --
            </option>
        `;

        sousPrefectureSelect.innerHTML = `
            <option value="">
                -- Sélectionner une sous-préfecture --
            </option>
        `;

        communeSelect.innerHTML = `
            <option value="">
                -- Sélectionner une commune --
            </option>
        `;

        localiteSelect.innerHTML = `
            <option value="">
                -- Sélectionner une localité --
            </option>
        `;

        regionSelect.disabled = true;
        departementSelect.disabled = true;
        sousPrefectureSelect.disabled = true;
        communeSelect.disabled = true;
        localiteSelect.disabled = true;

        coordonnees.classList.add('d-none');

        if (!districtId) {
            return;
        }

        chargerDonnees(
            `/localisation/districts/${districtId}/regions`,
            regionSelect,
            '-- Sélectionner une région --'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | REGION → DEPARTEMENT
    |--------------------------------------------------------------------------
    */

    regionSelect.addEventListener('change', function () {

        const regionId = this.value;

        departementSelect.innerHTML = `
            <option value="">
                -- Sélectionner un département --
            </option>
        `;

        sousPrefectureSelect.innerHTML = `
            <option value="">
                -- Sélectionner une sous-préfecture --
            </option>
        `;

        communeSelect.innerHTML = `
            <option value="">
                -- Sélectionner une commune --
            </option>
        `;

        localiteSelect.innerHTML = `
            <option value="">
                -- Sélectionner une localité --
            </option>
        `;

        departementSelect.disabled = true;
        sousPrefectureSelect.disabled = true;
        communeSelect.disabled = true;
        localiteSelect.disabled = true;

        coordonnees.classList.add('d-none');

        if (!regionId) {
            return;
        }

        chargerDonnees(
            `/localisation/regions/${regionId}/departements`,
            departementSelect,
            '-- Sélectionner un département --'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | DEPARTEMENT → SOUS-PREFECTURES + COMMUNES
    |--------------------------------------------------------------------------
    */

    departementSelect.addEventListener('change', function () {

        const departementId = this.value;

        sousPrefectureSelect.innerHTML = `
            <option value="">
                -- Sélectionner une sous-préfecture --
            </option>
        `;

        communeSelect.innerHTML = `
            <option value="">
                -- Sélectionner une commune --
            </option>
        `;

        localiteSelect.innerHTML = `
            <option value="">
                -- Sélectionner une localité --
            </option>
        `;

        sousPrefectureSelect.disabled = true;
        communeSelect.disabled = true;
        localiteSelect.disabled = true;

        coordonnees.classList.add('d-none');

        if (!departementId) {
            return;
        }

        chargerDonnees(
            `/localisation/departements/${departementId}/sous-prefectures`,
            sousPrefectureSelect,
            '-- Sélectionner une sous-préfecture --'
        );

        chargerDonnees(
            `/localisation/departements/${departementId}/communes`,
            communeSelect,
            '-- Sélectionner une commune --'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | COMMUNE → LOCALITES
    |--------------------------------------------------------------------------
    */

    communeSelect.addEventListener('change', function () {

        const communeId = this.value;

        localiteSelect.innerHTML = `
            <option value="">
                -- Sélectionner une localité --
            </option>
        `;

        localiteSelect.disabled = true;

        coordonnees.classList.add('d-none');

        if (!communeId) {
            return;
        }

        chargerDonnees(
            `/localisation/communes/${communeId}/localites`,
            localiteSelect,
            '-- Sélectionner une localité --'
        );

    });


    /*
    |--------------------------------------------------------------------------
    | LOCALITE → COORDONNEES GPS
    |--------------------------------------------------------------------------
    */

    localiteSelect.addEventListener('change', async function () {

        const localiteId = this.value;

        coordonnees.classList.add('d-none');

        if (!localiteId) {
            return;
        }

        try {

            const response = await fetch(
                `/localisation/communes/${communeSelect.value}/localites`
            );

            const data = await response.json();

            const localite = data.find(
                element => element.id == localiteId
            );

            if (localite) {

                latitude.textContent =
                    localite.latitude ?? '-';

                longitude.textContent =
                    localite.longitude ?? '-';

                coordonnees.classList.remove('d-none');

            }

        } catch (error) {

            console.error(error);

        }

    });


    /*
    |--------------------------------------------------------------------------
    | PRÉ-REMPLISSAGE (mode édition)
    |--------------------------------------------------------------------------
    */

    async function preRemplir() {

        if (!existant.district_id) {
            return;
        }

        districtSelect.value = existant.district_id;

        await chargerDonnees(
            `/localisation/districts/${existant.district_id}/regions`,
            regionSelect,
            '-- Sélectionner une région --'
        );

        if (existant.region_id) {
            regionSelect.value = existant.region_id;

            await chargerDonnees(
                `/localisation/regions/${existant.region_id}/departements`,
                departementSelect,
                '-- Sélectionner un département --'
            );
        }

        if (existant.departement_id) {
            departementSelect.value = existant.departement_id;

            await chargerDonnees(
                `/localisation/departements/${existant.departement_id}/sous-prefectures`,
                sousPrefectureSelect,
                '-- Sélectionner une sous-préfecture --'
            );

            await chargerDonnees(
                `/localisation/departements/${existant.departement_id}/communes`,
                communeSelect,
                '-- Sélectionner une commune --'
            );
        }

        if (existant.commune_id) {
            communeSelect.value = existant.commune_id;

            await chargerDonnees(
                `/localisation/communes/${existant.commune_id}/localites`,
                localiteSelect,
                '-- Sélectionner une localité --'
            );
        }

        if (existant.localite_id) {
            localiteSelect.value = existant.localite_id;

            const data = await fetch(`/localisation/communes/${existant.commune_id}/localites`).then(r => r.json());
            const localite = data.find(element => element.id == existant.localite_id);

            if (localite) {
                latitude.textContent = localite.latitude ?? '-';
                longitude.textContent = localite.longitude ?? '-';
                coordonnees.classList.remove('d-none');
            }
        }
    }

    preRemplir();

});

</script>