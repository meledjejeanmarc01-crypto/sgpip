<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Projet;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    public function store(Request $request, Projet $projet)
    {
        $data = $request->validate([
            'exercice' => 'required|integer|min:2000|max:2100',
            'credit_budgetaire_notifie' => 'nullable|numeric|min:0',
            'montant_pec_avant_exercice' => 'nullable|numeric|min:0',
            'montant_previsionnel_n' => 'nullable|numeric|min:0',
            'montant_previsionnel_n1' => 'nullable|numeric|min:0',
            'montant_previsionnel_n2' => 'nullable|numeric|min:0',
            'taux_execution_financier' => 'nullable|numeric|min:0|max:100',
            'taux_execution_physique' => 'nullable|numeric|min:0|max:100',
            'observation' => 'nullable|string',
        ]);
        $data['projet_id'] = $projet->id;
        Budget::create($data);
        return back()->with('success', 'Ligne budgétaire ajoutée avec succès.');
    }

    public function update(Request $request, Budget $budget)
    {
        $data = $request->validate([
            'exercice' => 'required|integer|min:2000|max:2100',
            'credit_budgetaire_notifie' => 'nullable|numeric|min:0',
            'montant_pec_avant_exercice' => 'nullable|numeric|min:0',
            'montant_previsionnel_n' => 'nullable|numeric|min:0',
            'montant_previsionnel_n1' => 'nullable|numeric|min:0',
            'montant_previsionnel_n2' => 'nullable|numeric|min:0',
            'taux_execution_financier' => 'nullable|numeric|min:0|max:100',
            'taux_execution_physique' => 'nullable|numeric|min:0|max:100',
            'observation' => 'nullable|string',
        ]);
        $budget->update($data);
        return back()->with('success', 'Ligne budgétaire mise à jour.');
    }

    public function destroy(Budget $budget)
    {
        $projet = $budget->projet;
        $budget->delete();
        return redirect()->route('projets.show', $projet)->with('success', 'Ligne budgétaire supprimée.');
    }
}
