<?php

namespace App\Http\Controllers;

use App\Models\TypeObjectif;
use Illuminate\Http\Request;

class TypeObjectifController extends Controller
{
    public function index()
    {
        $types = TypeObjectif::withCount('objectifs')->orderBy('libelle')->paginate(15);
        return view('types_objectif.index', compact('types'));
    }

    public function create()
    {
        return view('types_objectif.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_objectif,libelle']);
        TypeObjectif::create($data);
        return redirect()->route('types-objectif.index')->with('success', 'Type d\'objectif créé avec succès.');
    }

    public function edit(TypeObjectif $type_objectif)
    {
        return view('types_objectif.edit', ['type' => $type_objectif]);
    }

    public function update(Request $request, TypeObjectif $type_objectif)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_objectif,libelle,'.$type_objectif->id]);
        $type_objectif->update($data);
        return redirect()->route('types-objectif.index')->with('success', 'Type d\'objectif mis à jour.');
    }

    public function destroy(TypeObjectif $type_objectif)
    {
        if ($type_objectif->objectifs()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des objectifs sont rattachés à ce type.');
        }
        $type_objectif->delete();
        return back()->with('success', 'Type d\'objectif supprimé.');
    }
}
