<?php

namespace App\Http\Controllers;

use App\Models\EcheancierAeCp;
use App\Models\Marche;
use Illuminate\Http\Request;

class EcheancierAeCpController extends Controller
{
    public function store(Request $request, Marche $marche)
    {
        $data = $request->validate([
            'annee_lf' => 'required|integer|min:2000|max:2100',
            'montant_ae' => 'nullable|numeric|min:0',
            'montant_cp' => 'nullable|numeric|min:0',
        ]);
        $data['marche_id'] = $marche->id;
        EcheancierAeCp::create($data);
        return back()->with('success', 'Échéancier AE-CP ajouté avec succès.');
    }

    public function destroy(EcheancierAeCp $echeancier_ae_cp)
    {
        $projet = $echeancier_ae_cp->marche->projet;
        $echeancier_ae_cp->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Échéancier AE-CP supprimé.');
    }
}
