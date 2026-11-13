<?php

namespace App\Http\Controllers;

use App\Models\Projet;
use App\Models\Rapport;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
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
        $projets = $this->projetsAccessibles();
        return view('rapports.create', compact('projets'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);

        // RG17 : on ne crée un rapport que pour un projet que l'on gère.
        $this->autoriserProjet((int) $data['projet_id']);

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
        // Le middleware projet.acces ne contrôle pas les requêtes GET : on vérifie ici.
        $this->autoriserProjet((int) $rapport->projet_id);

        $projets = $this->projetsAccessibles();
        return view('rapports.edit', compact('rapport', 'projets'));
    }

    public function update(Request $request, Rapport $rapport)
    {
        // RG17 : le projet actuel ET le projet visé par le formulaire doivent être gérés par l'utilisateur.
        $this->autoriserProjet((int) $rapport->projet_id);

        $data = $this->validateData($request);
        $this->autoriserProjet((int) $data['projet_id']);

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
        $this->autoriserProjet((int) $rapport->projet_id);

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

    // Un gestionnaire ne peut choisir que parmi les projets qu'il gère ; l'administrateur voit tout.
    private function projetsAccessibles()
    {
        $user = auth()->user();

        return Projet::orderBy('intitule')
            ->when(! $user->isAdministrateur(), fn ($q) => $q->whereIn('id', $user->projetsGeres()->pluck('projets.id')))
            ->get();
    }

    private function validateData(Request $request): array
    {
        $data = $request->validate([
            'type' => 'required|in:avancement,financier,physique,suivi,annuel,trimestriel,mensuel,synthese,execution,cloture',
            'titre' => 'required|string|max:255',
            'periode' => 'nullable|string|max:100',
            'donnees' => 'nullable|string',
            'date' => 'required|date',
            'projet_id' => 'required|exists:projets,id',
            'fichier' => 'nullable|file|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        // RG19 : le rapport de clôture n'est possible que lorsque l'avancement atteint 100 %.
        if ($data['type'] === 'cloture' && (int) Projet::findOrFail($data['projet_id'])->avancement_physique < 100) {
            throw ValidationException::withMessages([
                'type' => "Un rapport de clôture n'est possible que lorsque l'avancement du projet atteint 100 %.",
            ]);
        }

        return $data;
    }
}
