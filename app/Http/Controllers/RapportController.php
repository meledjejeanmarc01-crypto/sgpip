<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RapportController extends Controller
{
    public function index(Request $request)
    {
        $rapports = Rapport::with(['projet', 'utilisateur'])
            ->when($request->q, fn ($q) => $q->where('titre', 'like', "%{$request->q}%"))
            ->when($request->type, fn ($q) => $q->where('type', $request->type))
            ->orderByDesc('date')
            ->paginate(15)
            ->withQueryString();
        return view('rapports.index', compact('rapports'));
    }

    public function create()
    {
        $projets = Projet::orderBy('intitule')->get();
        return view('rapports.create', compact('projets'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        $data['utilisateur_id'] = $request->user()->id;

        if ($request->hasFile('fichier')) {
            $data['fichier'] = $request->file('fichier')->store('rapports', 'public');
        }

        Rapport::create($data);
        return redirect()->route('rapports.index')->with('success', 'Rapport créé avec succès.');
    }

    public function show(Rapport $rapport)
    {
        $rapport->load('projet', 'utilisateur');
        return view('rapports.show', compact('rapport'));
    }

    public function edit(Rapport $rapport)
    {
        $projets = Projet::orderBy('intitule')->get();
        return view('rapports.edit', compact('rapport', 'projets'));
    }

    public function update(Request $request, Rapport $rapport)
    {
        $data = $this->validateData($request);

        if ($request->hasFile('fichier')) {
            if ($rapport->fichier) {
                Storage::disk('public')->delete($rapport->fichier);
            }
            $data['fichier'] = $request->file('fichier')->store('rapports', 'public');
        }

        $rapport->update($data);
        return redirect()->route('rapports.index')->with('success', 'Rapport mis à jour.');
    }

    public function destroy(Rapport $rapport)
    {
        if ($rapport->fichier) {
            Storage::disk('public')->delete($rapport->fichier);
        }
        $rapport->delete();
        return back()->with('success', 'Rapport supprimé.');
    }

    public function download(Rapport $rapport)
    {
        abort_unless($rapport->fichier, 404);
        return Storage::disk('public')->download($rapport->fichier, $rapport->titre.'.'.pathinfo($rapport->fichier, PATHINFO_EXTENSION));
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:avancement,financier,physique,suivi,annuel,trimestriel,mensuel,synthese,execution',
            'titre' => 'required|string|max:255',
            'donnees' => 'nullable|string',
            'date' => 'required|date',
            'projet_id' => 'required|exists:projets,id',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);
    }
}
