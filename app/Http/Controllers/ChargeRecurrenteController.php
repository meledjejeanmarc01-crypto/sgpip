<?php

namespace App\Http\Controllers;

use App\Models\ChargeRecurrente;
use App\Models\Projet;
use Illuminate\Http\Request;

class ChargeRecurrenteController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'rubrique' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'montant' => 'required|numeric|min:0',
            'annee' => 'required|integer|min:2000|max:2100',
        ]);
        $data['projet_id'] = $projet->id;
        ChargeRecurrente::create($data);
        return back()->with('success', 'Charge récurrente ajoutée avec succès.');
    }

    public function update(Request $request, ChargeRecurrente $chargeRecurrente)
    {
        $data = $request->validate([
            'rubrique' => 'required|string|max:255',
            'categorie' => 'nullable|string|max:255',
            'montant' => 'required|numeric|min:0',
            'annee' => 'required|integer|min:2000|max:2100',
        ]);
        $chargeRecurrente->update($data);
        return back()->with('success', 'Charge récurrente mise à jour.');
    }

    public function destroy(ChargeRecurrente $chargeRecurrente)
    {
        $projet = $chargeRecurrente->projet;
        $chargeRecurrente->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Charge récurrente supprimée.');
    }
}
