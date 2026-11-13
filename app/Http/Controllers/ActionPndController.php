<?php

namespace App\Http\Controllers;

use App\Models\ActionPnd;
use Illuminate\Http\Request;

// ACTION_PND — cahier : "id, libelle, description" (RG40).
class ActionPndController extends Controller
{
    public function index()
    {
        $actions = ActionPnd::withCount('projets')->orderBy('libelle')->paginate(15);
        return view('actions_pnd.index', compact('actions'));
    }

    public function create()
    {
        return view('actions_pnd.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255|unique:actions_pnd,libelle',
            'description' => 'nullable|string',
        ]);
        $action = ActionPnd::create($data);

        // Création rapide depuis le formulaire de projet (réponse JSON, sans quitter la page).
        if ($request->wantsJson()) {
            return response()->json(['id' => $action->id, 'libelle' => $action->libelle, 'sigle' => null], 201);
        }

        return redirect()->route('actions-pnd.index')->with('success', 'Action PND créée avec succès.');
    }

    public function edit(ActionPnd $action_pnd)
    {
        return view('actions_pnd.edit', ['action' => $action_pnd]);
    }

    public function update(Request $request, ActionPnd $action_pnd)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255|unique:actions_pnd,libelle,'.$action_pnd->id,
            'description' => 'nullable|string',
        ]);
        $action_pnd->update($data);
        return redirect()->route('actions-pnd.index')->with('success', 'Action PND mise à jour.');
    }

    public function destroy(ActionPnd $action_pnd)
    {
        if ($action_pnd->projets()->exists()) {
            return back()->with('error', 'Impossible de supprimer : des projets sont rattachés à cette action.');
        }
        $action_pnd->delete();
        return back()->with('success', 'Action PND supprimée.');
    }
}
