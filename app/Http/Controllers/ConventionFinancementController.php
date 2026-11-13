<?php

namespace App\Http\Controllers;

use App\Models\ConventionFinancement;
use App\Models\Financement;
use Illuminate\Http\Request;

class ConventionFinancementController extends Controller
{
    protected function rules(): array
    {
        return [
            'type_accord' => 'nullable|string|max:255',
            'nature_financement' => 'nullable|string|max:255',
            'date_limite_tirage' => 'nullable|date',
            'niveau_avancement_negociations' => 'nullable|string|max:255',
            'numero_accord_signe' => 'nullable|string|max:255',
            'montant' => 'nullable|numeric|min:0',
            'date_signature' => 'nullable|date',
            // Feuille PLANIFICATION, section 3
            'engagement_contractuel' => 'nullable|boolean',
            'date_avancement_negociations' => 'nullable|date',
            'proroge' => 'nullable|boolean',
            'duree_prorogation_mois' => 'nullable|integer|min:0|max:600',
        ];
    }

    // Liste de toutes les conventions de financement.
    public function index()
    {
        $conventions = ConventionFinancement::with('financement.projet', 'financement.bailleur')
            ->latest('date_signature')
            ->paginate(20);

        return view('conventions.index', compact('conventions'));
    }

    public function store(Request $request, Financement $financement)
    {
        $data = $request->validate($this->rules());
        $data['financement_id'] = $financement->id;
        ConventionFinancement::updateOrCreate(['financement_id' => $financement->id], $data);
        return back()->with('success', 'Convention de financement enregistrée.');
    }

    public function update(Request $request, ConventionFinancement $conventionFinancement)
    {
        $data = $request->validate($this->rules());
        $conventionFinancement->update($data);
        return back()->with('success', 'Convention de financement mise à jour.');
    }

    public function destroy(ConventionFinancement $conventionFinancement)
    {
        $financement = $conventionFinancement->financement;
        $conventionFinancement->delete();
        return redirect()->route('financements.edit', $financement)->with('success', 'Convention de financement supprimée.');
    }
}
