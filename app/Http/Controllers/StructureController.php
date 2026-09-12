<?php

namespace App\Http\Controllers;

use App\Models\Structure;
use App\Models\TypeStructure;
use Illuminate\Http\Request;

class StructureController extends Controller
{
    public function index(Request $request)
    {
        $structures = Structure::with('typeStructure')
            ->when($request->q, fn ($q) => $q->where('libelle', 'like', "%{$request->q}%"))
            ->orderBy('libelle')
            ->paginate(15)
            ->withQueryString();
        return view('structures.index', compact('structures'));
    }

    public function create()
    {
        $types = TypeStructure::orderBy('libelle')->get();
        return view('structures.create', compact('types'));
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        Structure::create($data);
        return redirect()->route('structures.index')->with('success', 'Structure créée avec succès.');
    }

    public function show(Structure $structure)
    {
        $structure->load('typeStructure', 'projets', 'programmes');
        return view('structures.show', compact('structure'));
    }

    public function edit(Structure $structure)
    {
        $types = TypeStructure::orderBy('libelle')->get();
        return view('structures.edit', compact('structure', 'types'));
    }

    public function update(Request $request, Structure $structure)
    {
        $data = $this->validateData($request);
        $structure->update($data);
        return redirect()->route('structures.index')->with('success', 'Structure mise à jour.');
    }

    public function destroy(Structure $structure)
    {
        if ($structure->projets()->exists() || $structure->programmes()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des projets ou programmes sont rattachés à cette structure.');
        }
        $structure->delete();
        return back()->with('success', 'Structure supprimée.');
    }

    private function validateData(Request $request): array
    {
        return $request->validate([
            'libelle' => 'required|string|max:255',
            'sigle' => 'nullable|string|max:50',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'nullable|string|max:50',
            'type_structure_id' => 'required|exists:types_structure,id',
        ]);
    }
}
