<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// §9.1 : gestion du mot de passe (changement par l'utilisateur connecté).
class MotDePasseController extends Controller
{
    public function edit()
    {
        return view('auth.mot-de-passe');
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'password_actuel' => 'required|current_password',
            'password' => 'required|string|min:8|confirmed|different:password_actuel',
        ], [], [
            'password_actuel' => 'mot de passe actuel',
            'password' => 'nouveau mot de passe',
        ]);

        $request->user()->update(['password' => $data['password']]);

        return redirect()->route('mot-de-passe.edit')->with('success', 'Votre mot de passe a été modifié.');
    }
}
