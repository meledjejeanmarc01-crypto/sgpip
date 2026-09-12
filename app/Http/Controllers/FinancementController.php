<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Etat;
use App\Models\Financement;
use App\Models\Projet;
use Illuminate\Http\Request;

class FinancementController extends Controller
{
    public function index(Request $request)
    {
        $financements = Financement::with(['projet', 'bailleur', 'etat'])
            ->when($request->q, fn ($q) => $q->where('reference', 'like', "%{$request->q}%"))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('financements.index', compact('financements'));
    }

    public function create()
    {
        [$projets, $bailleurs, $etats] = $this->referenceData();
        return view('financements.create', compact('projets', 'bailleurs', 'etats'));
    }

    public function store(Request $request)
    {
        Financement::create($this->validateData($request));
        return redirect()->route('financements.index')->with('success', 'Financement enregistré avec succès.');
    }

    public function edit(Financement $financement)
    {
        [$projets, $bailleurs, $etats] = $this->referenceData();
        return view('financements.edit', compact('financement', 'projets', 'bailleurs', 'etats'));
    }

    public function update(Request $request, Financement $financement)
    {
        $financement->update($this->validateData($request, $financement->id));
        return redirect()->route('financements.index')->with('success', 'Financement mis à jour.');
    }

    public function destroy(Financement $financement)
    {
        if ($financement->decaissements()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des décaissements sont rattachés à ce financement.');
        }
        $financement->delete();
        return back()->with('success', 'Financement supprimé.');
    }

    private function referenceData(): array
    {
        return [
            Projet::orderBy('intitule')->get(),
            Bailleur::orderBy('nom')->get(),
            Etat::orderBy('libelle')->get(),
        ];
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        $data = $request->validate([
            'montant_engage' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string|max:50|unique:financements,reference,'.$ignoreId,
            'projet_id' => 'required|exists:projets,id',
            'source_type' => 'required|in:bailleur,etat',
            'bailleur_id' => 'required_if:source_type,bailleur|nullable|exists:bailleurs,id',
            'etat_id' => 'required_if:source_type,etat|nullable|exists:etats,id',
        ]);

        if ($data['source_type'] === 'bailleur') {
            $data['etat_id'] = null;
        } else {
            $data['bailleur_id'] = null;
        }
        unset($data['source_type']);

        return $data;
    }
}
