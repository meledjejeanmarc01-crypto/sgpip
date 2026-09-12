<?php

namespace App\Http\Controllers;

use App\Models\Programme;
use App\Models\Structure;
use Illuminate\Http\Request;

class ProgrammeController extends Controller
{
    public function index(Request $request)
    {
        $programmes = Programme::with('structure')
            ->when($request->q, fn ($q) => $q->where('nom', 'like', "%{$request->q}%")->orWhere('code', 'like', "%{$request->q}%"))
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();
        return view('programmes.index', compact('programmes'));
    }

    public function create()
    {
        $structures = Structure::orderBy('libelle')->get();
        return view('programmes.create', compact('structures'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Programme::create($data);
        return redirect()->route('programmes.index')->with('success', 'Programme créé avec succès.');
    }

    public function show(Programme $programme)
    {
        $programme->load('structure', 'fichesPip.projets', 'axes');
        return view('programmes.show', compact('programme'));
    }

    public function edit(Programme $programme)
    {
        $structures = Structure::orderBy('libelle')->get();
        return view('programmes.edit', compact('programme', 'structures'));
    }

    public function update(Request $request, Programme $programme)
    {
        $data = $this->validateData($request);
        $programme->update($data);
        return redirect()->route('programmes.index')->with('success', 'Programme mis à jour.');
    }

    public function destroy(Programme $programme)
    {
        if ($programme->fichesPip()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des fiches PIP sont rattachées à ce programme.');
        }
        $programme->delete();
        return back()->with('success', 'Programme supprimé.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'nom' => 'required|string|max:255',
            'libelle' => 'nullable|string|max:255',
            'code' => 'required|string|max:50|unique:programmes,code,'.$request->route('programme')?->id,
            'date_debut' => 'nullable|date',
            'date_fin' => 'nullable|date|after_or_equal:date_debut',
            'structure_id' => 'required|exists:structures,id',
        ]);
    }
}
