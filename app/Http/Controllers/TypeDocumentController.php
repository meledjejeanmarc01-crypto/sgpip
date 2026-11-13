<?php

namespace App\Http\Controllers;

use App\Models\TypeDocument;
use Illuminate\Http\Request;

// TYPE_DOCUMENT — cahier : "id, libéllé" (RG39).
class TypeDocumentController extends Controller
{
    public function index()
    {
        $types = TypeDocument::withCount('documents')->orderBy('libelle')->paginate(15);
        return view('types_document.index', compact('types'));
    }

    public function create()
    {
        return view('types_document.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_document,libelle']);
        $type = TypeDocument::create($data);

        if ($request->wantsJson() || $request->ajax()) {
            return response()->json(['id' => $type->id, 'libelle' => $type->libelle]);
        }

        return redirect()->route('types-document.index')->with('success', 'Type de document créé avec succès.');
    }

    public function edit(TypeDocument $type_document)
    {
        return view('types_document.edit', ['type' => $type_document]);
    }

    public function update(Request $request, TypeDocument $type_document)
    {
        $data = $request->validate(['libelle' => 'required|string|max:255|unique:types_document,libelle,'.$type_document->id]);
        $type_document->update($data);
        return redirect()->route('types-document.index')->with('success', 'Type de document mis à jour.');
    }

    public function destroy(TypeDocument $type_document)
    {
        if ($type_document->documents()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des documents sont rattachés à ce type.');
        }
        $type_document->delete();
        return back()->with('success', 'Type de document supprimé.');
    }
}
