<?php

namespace App\Http\Controllers;

use App\Models\PieceJustificative;
use App\Models\Projet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PieceJustificativeController extends Controller
{
    public function index(Request $request)
    {
        $pieces = PieceJustificative::with(['projet', 'utilisateur'])
            ->when($request->categorie, fn ($q) => $q->where('categorie', $request->categorie))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();
        return view('pieces.index', compact('pieces'));
    }

    public function create()
    {
        $projets = Projet::orderBy('intitule')->get();
        return view('pieces.create', compact('projets'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'nullable|string|max:255',
            'categorie' => 'required|in:facture,recu,contrat,proces_verbal,autre',
            'projet_id' => 'required|exists:projets,id',
            'fichier' => 'required|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        $data['fichier'] = $request->file('fichier')->store('pieces-justificatives', 'public');
        $data['utilisateur_id'] = $request->user()->id;

        PieceJustificative::create($data);
        return redirect()->route('pieces.index')->with('success', 'Pièce justificative ajoutée avec succès.');
    }

    public function destroy(PieceJustificative $piece)
    {
        Storage::disk('public')->delete($piece->fichier);
        $piece->delete();
        return back()->with('success', 'Pièce justificative supprimée.');
    }

    public function download(PieceJustificative $piece)
    {
        return Storage::disk('public')->download($piece->fichier);
    }
}
