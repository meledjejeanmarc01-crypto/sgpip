<?php

namespace App\Http\Controllers;

use App\Models\Axe;
use App\Models\Reforme;
use App\Models\Structure;
use Illuminate\Http\Request;

class ReformeController extends Controller
{
    protected function rules(): array
    {
        return [
            'libelle' => 'required|string|max:255',
            'resultat_global_attendu' => 'nullable|string',
            'statut' => 'required|in:demarree,en_cours,achevee',
            'date_transmission_sgg' => 'nullable|date',
            'annee_debut' => 'nullable|integer|min:2000|max:2100',
            'annee_fin' => 'nullable|integer|min:2000|max:2100',
            'taux_execution_annee_precedente' => 'nullable|numeric|min:0|max:100',
            'taux_execution_previsionnel' => 'nullable|numeric|min:0|max:100',
            'cible_trimestre_1' => 'nullable|string|max:255',
            'cible_trimestre_2' => 'nullable|string|max:255',
            'cible_trimestre_3' => 'nullable|string|max:255',
            'cible_trimestre_4' => 'nullable|string|max:255',
            'localite' => 'nullable|string|max:255',
            'budget_global' => 'nullable|numeric|min:0',
            'source_financement' => 'nullable|string|max:255',
            'montant_etat' => 'nullable|numeric|min:0',
            'montant_autres_bailleurs' => 'nullable|numeric|min:0',
            'livrables_attendus' => 'nullable|string',
            'indicateurs' => 'nullable|string',
            'code_pjgouv' => 'nullable|string|max:255',
            'code_psgouv' => 'nullable|string|max:255',
            'observations' => 'nullable|string',
            'structure_id' => 'required|exists:structures,id',
            'axe_id' => 'nullable|exists:axes,id',
        ];
    }

    public function index(Request $request)
    {
        $reformes = Reforme::with(['structure', 'axe.programme'])
            ->when($request->q, fn ($q) => $q->where('libelle', 'like', '%'.$request->q.'%'))
            ->when($request->statut, fn ($q) => $q->where('statut', $request->statut))
            ->orderBy('libelle')
            ->paginate(15)
            ->withQueryString();
        return view('reformes.index', compact('reformes'));
    }

    public function create()
    {
        $structures = Structure::orderBy('libelle')->get();
        $axes = Axe::with('programme')->orderBy('libelle')->get();
        return view('reformes.create', compact('structures', 'axes'));
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $reforme = Reforme::create($data);
        return redirect()->route('reformes.show', $reforme)->with('success', 'Réforme créée avec succès.');
    }

    public function show(Reforme $reforme)
    {
        $reforme->load(['structure', 'axe.programme']);
        return view('reformes.show', compact('reforme'));
    }

    public function edit(Reforme $reforme)
    {
        $structures = Structure::orderBy('libelle')->get();
        $axes = Axe::with('programme')->orderBy('libelle')->get();
        return view('reformes.edit', compact('reforme', 'structures', 'axes'));
    }

    public function update(Request $request, Reforme $reforme)
    {
        $data = $request->validate($this->rules());
        $reforme->update($data);
        return redirect()->route('reformes.show', $reforme)->with('success', 'Réforme mise à jour.');
    }

    public function destroy(Reforme $reforme)
    {
        $reforme->delete();
        return redirect()->route('reformes.index')->with('success', 'Réforme supprimée.');
    }
}
