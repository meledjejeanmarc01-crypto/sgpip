<?php

namespace App\Http\Controllers;

use App\Models\TypePartiePrenante;
use Illuminate\Http\Request;

class TypePartiePrenanteController extends Controller
{
    public function index()
    {
        $types = TypePartiePrenante::withCount('partiesPrenantes')->orderBy('libelle')->paginate(15);
        return view('types_partie_prenante.index', compact('types'));
    }

    public function create()
    {
        return view('types_partie_prenante.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_partie_prenante,libelle']);
        TypePartiePrenante::create($data);
        return redirect()->route('types-partie-prenante.index')->with('success', 'Type de partie prenante créé avec succès.');
    }

    public function edit(TypePartiePrenante $type_partie_prenante)
    {
        return view('types_partie_prenante.edit', ['type' => $type_partie_prenante]);
    }

    public function update(Request $request, TypePartiePrenante $type_partie_prenante)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_partie_prenante,libelle,'.$type_partie_prenante->id]);
        $type_partie_prenante->update($data);
        return redirect()->route('types-partie-prenante.index')->with('success', 'Type de partie prenante mis à jour.');
    }

    public function destroy(TypePartiePrenante $type_partie_prenante)
    {
        if ($type_partie_prenante->partiesPrenantes()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des parties prenantes sont rattachées à ce type.');
        }
        $type_partie_prenante->delete();
        return back()->with('success', 'Type de partie prenante supprimé.');
    }
}
