<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UtilisateurController extends Controller
{
    public function index(Request $request)
    {
        $utilisateurs = User::when($request->q, fn ($q) => $q->where('nom', 'like', "%{$request->q}%")->orWhere('email', 'like', "%{$request->q}%"))
            ->orderBy('nom')
            ->paginate(15)
            ->withQueryString();
        return view('utilisateurs.index', compact('utilisateurs'));
    }

    public function create()
    {
        return view('utilisateurs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:administrateur,gestionnaire_projet,responsable_financier,responsable_suivi_evaluation,consultant',
        ]);
        $data['password'] = Hash::make($data['password']);
        User::create($data);
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur créé avec succès.');
    }

    public function edit(User $utilisateur)
    {
        return view('utilisateurs.edit', compact('utilisateur'));
    }

    public function update(Request $request, User $utilisateur)
    {
        $data = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$utilisateur->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role' => 'required|in:administrateur,gestionnaire_projet,responsable_financier,responsable_suivi_evaluation,consultant',
            'actif' => 'sometimes|boolean',
        ]);

        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }
        $data['actif'] = $request->boolean('actif');

        $utilisateur->update($data);
        return redirect()->route('utilisateurs.index')->with('success', 'Utilisateur mis à jour.');
    }

    public function destroy(User $utilisateur)
    {
        if ($utilisateur->id === auth()->id()) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }
        $utilisateur->delete();
        return back()->with('success', 'Utilisateur supprimé.');
    }
}
