<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        // Si déjà connecté, rediriger vers le dashboard
        if (Session::has('user_id')) {
            return redirect()->route('praticiens.index');
        }
        
        return view('auth.login');
    }

    // Traiter la connexion
    public function login(Request $request)
    {
        $request->validate([
            'nom' => 'required|string',
            'mdp' => 'required|string',
        ]);

        // Chercher l'utilisateur
        $utilisateur = Utilisateur::where('nom', $request->nom)->first();

        // Vérifier si l'utilisateur existe et si le mot de passe est correct
        if ($utilisateur && $utilisateur->checkPassword($request->mdp)) {
            // Stocker les informations en session
            Session::put('user_id', $utilisateur->id);
            Session::put('user_nom', $utilisateur->nom);
            Session::put('is_admin', $utilisateur->isAdmin());

            return redirect()->route('praticiens.index')
                ->with('success', 'Connexion réussie ! Bienvenue ' . $utilisateur->nom);
        }

        // Si échec de connexion
        return back()->withErrors([
            'login' => 'Identifiants incorrects.',
        ])->withInput($request->only('nom'));
    }

    // Déconnexion
    public function logout()
    {
        Session::flush();
        return redirect()->route('login')
            ->with('success', 'Vous avez été déconnecté avec succès.');
    }
}