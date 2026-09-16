<?php

namespace App\Http\Controllers;

use App\Models\TypeBailleur;
use Illuminate\Http\Request;

class TypeBailleurController extends Controller
{
    public function index()
    {
        $types = TypeBailleur::withCount('bailleurs')->orderBy('libelle')->paginate(15);
        return view('types_bailleur.index', compact('types'));
    }

    public function create()
    {
        return view('types_bailleur.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_bailleur,libelle']);
        $type = TypeBailleur::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['id' => $type->id, 'libelle' => $type->libelle]);
        }

        return redirect()->route('types-bailleur.index')->with('success', 'Type de bailleur créé avec succès.');
    }

    public function edit(TypeBailleur $type_bailleur)
    {
        return view('types_bailleur.edit', ['type' => $type_bailleur]);
    }

    public function update(Request $request, TypeBailleur $type_bailleur)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_bailleur,libelle,'.$type_bailleur->id]);
        $type_bailleur->update($data);
        return redirect()->route('types-bailleur.index')->with('success', 'Type de bailleur mis à jour.');
    }

    public function destroy(TypeBailleur $type_bailleur)
    {
        if ($type_bailleur->bailleurs()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des bailleurs sont rattachés à ce type.');
        }
        $type_bailleur->delete();
        return back()->with('success', 'Type de bailleur supprimé.');
    }
}
