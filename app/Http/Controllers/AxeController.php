<?php

namespace App\Http\Controllers;

use App\Models\Axe;
use App\Models\Programme;
use Illuminate\Http\Request;

class AxeController extends Controller
{
    public function store(Request $request, Programme $programme)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);
        $data['programme_id'] = $programme->id;
        Axe::create($data);
        return back()->with('success', 'Axe ajouté avec succès.');
    }

    public function update(Request $request, Axe $axe)
    {
        $data = $request->validate([
            'libelle' => 'required|string|max:255',
        ]);
        $axe->update($data);
        return back()->with('success', 'Axe mis à jour.');
    }

    public function destroy(Axe $axe)
    {
        $programme = $axe->programme;
        $axe->delete();
        return redirect()->route('programmes.show', $programme)->with('success', 'Axe supprimé.');
    }
}
