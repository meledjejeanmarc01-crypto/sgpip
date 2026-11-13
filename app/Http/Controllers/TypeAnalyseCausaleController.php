<?php

namespace App\Http\Controllers;

use App\Models\TypeAnalyseCausale;
use Illuminate\Http\Request;

class TypeAnalyseCausaleController extends Controller
{
    public function index()
    {
        $types = TypeAnalyseCausale::withCount('analysesCausales')->orderBy('libelle')->paginate(15);
        return view('types_analyse_causale.index', compact('types'));
    }

    public function create()
    {
        return view('types_analyse_causale.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_analyse_causale,libelle']);
        $type = TypeAnalyseCausale::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['id' => $type->id, 'libelle' => $type->libelle], 201);
        }

        return redirect()->route('types-analyse-causale.index')->with('success', 'Type d\'analyse causale créé avec succès.');
    }

    public function edit(TypeAnalyseCausale $type_analyse_causale)
    {
        return view('types_analyse_causale.edit', ['type' => $type_analyse_causale]);
    }

    public function update(Request $request, TypeAnalyseCausale $type_analyse_causale)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_analyse_causale,libelle,'.$type_analyse_causale->id]);
        $type_analyse_causale->update($data);
        return redirect()->route('types-analyse-causale.index')->with('success', 'Type d\'analyse causale mis à jour.');
    }

    public function destroy(TypeAnalyseCausale $type_analyse_causale)
    {
        if ($type_analyse_causale->analysesCausales()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des analyses causales sont rattachées à ce type.');
        }
        $type_analyse_causale->delete();
        return back()->with('success', 'Type d\'analyse causale supprimé.');
    }
}
