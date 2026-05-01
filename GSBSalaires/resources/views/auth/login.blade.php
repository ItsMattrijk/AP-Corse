@extends('layout')

@section('title', 'Connexion - GSB')

@section('content')
<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full">
        <!-- Logo et titre -->
        <div class="text-center mb-8">
            <div class="flex justify-center mb-4">
                <div class="bg-indigo-600 rounded-full p-6 shadow-2xl">
                    <i class="fas fa-hospital text-white text-6xl"></i>
                </div>
            </div>
            <h2 class="text-4xl font-extrabold text-gray-900 mb-2">
                GSB - Connexion
            </h2>
            <p class="text-gray-600">
                Gestion des Salaires des Praticiens
            </p>
        </div>

        <!-- Formulaire de connexion -->
        <div class="bg-white rounded-2xl shadow-2xl p-8 border-t-4 border-indigo-600">
            <form method="POST" action="{{ route('login.post') }}" class="space-y-6">
                @csrf

                <!-- Nom d'utilisateur -->
                <div>
                    <label for="nom" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>
                        Nom d'utilisateur
                    </label>
                    <input 
                        id="nom" 
                        name="nom" 
                        type="text" 
                        required 
                        value="{{ old('nom') }}"
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        placeholder="Entrez votre nom d'utilisateur">
                </div>

                <!-- Mot de passe -->
                <div>
                    <label for="mdp" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-indigo-600"></i>
                        Mot de passe
                    </label>
                    <input 
                        id="mdp" 
                        name="mdp" 
                        type="password" 
                        required 
                        class="appearance-none relative block w-full px-4 py-3 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200"
                        placeholder="Entrez votre mot de passe">
                </div>

                <!-- Bouton de connexion -->
                <div>
                    <button 
                        type="submit" 
                        class="group relative w-full flex justify-center py-3 px-4 border border-transparent text-lg font-semibold rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-200 shadow-lg hover:shadow-xl">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Se connecter
                    </button>
                </div>
            </form>

            <!-- Informations de test -->
            <div class="mt-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
                <p class="text-sm text-blue-800 font-semibold mb-2">
                    <i class="fas fa-info-circle mr-2"></i>
                    Comptes de test :
                </p>
                <div class="text-xs text-blue-700 space-y-1">
                    <p><strong>Admin :</strong> admin / admin123</p>
                    <p><strong>Utilisateur :</strong> utilisateur / utilisateur</p>
                </div>
            </div>
        </div>

        <!-- Copyright -->
        <p class="mt-8 text-center text-sm text-gray-600">
            © {{ date('Y') }} GSB - Service des Ressources Humaines
        </p>
    </div>
</div>
@endsection