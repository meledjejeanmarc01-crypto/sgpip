<?php

namespace App\Http\Controllers;

use App\Models\TypeStructure;
use Illuminate\Http\Request;

class TypeStructureController extends Controller
{
    public function index()
    {
        $types = TypeStructure::withCount('structures')->orderBy('libelle')->paginate(15);
        return view('types_structure.index', compact('types'));
    }

    public function create()
    {
        return view('types_structure.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_structure,libelle']);
        TypeStructure::create($data);
        return redirect()->route('types-structure.index')->with('success', 'Type de structure créé avec succès.');
    }

    public function edit(TypeStructure $type_structure)
    {
        return view('types_structure.edit', ['type' => $type_structure]);
    }

    public function update(Request $request, TypeStructure $type_structure)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_structure,libelle,'.$type_structure->id]);
        $type_structure->update($data);
        return redirect()->route('types-structure.index')->with('success', 'Type de structure mis à jour.');
    }

    public function destroy(TypeStructure $type_structure)
    {
        if ($type_structure->structures()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des structures sont rattachées à ce type.');
        }
        $type_structure->delete();
        return back()->with('success', 'Type de structure supprimé.');
    }
}
