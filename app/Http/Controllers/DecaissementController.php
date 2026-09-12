<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\Decaissement;
use App\Models\Financement;
use Illuminate\Http\Request;

class DecaissementController extends Controller
{
    public function index(Request $request)
    {
        $decaissements = Decaissement::with(['bailleur', 'financement.projet'])
            ->when($request->q, fn ($q) => $q->where('reference', 'like', "%{$request->q}%"))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('decaissements.index', compact('decaissements'));
    }

    public function create()
    {
        [$bailleurs, $financements] = $this->referenceData();
        return view('decaissements.create', compact('bailleurs', 'financements'));
    }

    public function store(Request $request)
    {
        Decaissement::create($this->validateData($request));
        return redirect()->route('decaissements.index')->with('success', 'Décaissement enregistré avec succès.');
    }

    public function edit(Decaissement $decaissement)
    {
        [$bailleurs, $financements] = $this->referenceData();
        return view('decaissements.edit', compact('decaissement', 'bailleurs', 'financements'));
    }

    public function update(Request $request, Decaissement $decaissement)
    {
        $decaissement->update($this->validateData($request, $decaissement->id));
        return redirect()->route('decaissements.index')->with('success', 'Décaissement mis à jour.');
    }

    public function destroy(Decaissement $decaissement)
    {
        $decaissement->delete();
        return back()->with('success', 'Décaissement supprimé.');
    }

    private function referenceData(): array
    {
        return [
            Bailleur::orderBy('nom')->get(),
            Financement::with('projet')->orderByDesc('date')->get(),
        ];
    }

    private function validateData(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'montant' => 'required|numeric|min:0',
            'date' => 'required|date',
            'reference' => 'required|string|max:50|unique:decaissements,reference,'.$ignoreId,
            'bailleur_id' => 'required|exists:bailleurs,id',
            'financement_id' => 'nullable|exists:financements,id',
        ]);
    }
}
