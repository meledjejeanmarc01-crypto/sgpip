<?php

namespace App\Http\Controllers;

use App\Models\Bailleur;
use App\Models\TypeBailleur;
use Illuminate\Http\Request;

class BailleurController extends Controller
{
    public function index(Request $request)
    {
        $bailleurs = Bailleur::with('typeBailleur')
            ->when($request->q, fn ($q) => $q->where('nom', 'like', "%{$request->q}%"))
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();
        return view('bailleurs.index', compact('bailleurs'));
    }

    public function create()
    {
        $types = TypeBailleur::orderBy('libelle')->get();
        return view('bailleurs.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Bailleur::create($data);
        return redirect()->route('bailleurs.index')->with('success', 'Bailleur créé avec succès.');
    }

    public function show(Bailleur $bailleur)
    {
        $bailleur->load('typeBailleur', 'financements.projet', 'decaissements');
        return view('bailleurs.show', compact('bailleur'));
    }

    public function edit(Bailleur $bailleur)
    {
        $types = TypeBailleur::orderBy('libelle')->get();
        return view('bailleurs.edit', compact('bailleur', 'types'));
    }

    public function update(Request $request, Bailleur $bailleur)
    {
        $data = $this->validateData($request);
        $bailleur->update($data);
        return redirect()->route('bailleurs.index')->with('success', 'Bailleur mis à jour.');
    }

    public function destroy(Bailleur $bailleur)
    {
        if ($bailleur->financements()->exists() || $bailleur->decaissements()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des financements ou décaissements sont rattachés à ce bailleur.');
        }
        $bailleur->delete();
        return back()->with('success', 'Bailleur supprimé.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:50',
            'contact' => 'nullable|string|max:255',
            'type_bailleur_id' => 'required|exists:types_bailleur,id',
        ]);
    }
}
