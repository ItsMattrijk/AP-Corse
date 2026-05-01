@extends('layout')

@section('title', 'Détail Praticien - ' . $praticien->nom_complet)

@section('content')
<div class="space-y-6">
    <!-- Bouton retour -->
    <div>
        <a href="{{ route('praticiens.index') }}" 
           class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition-colors duration-200 shadow-md">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste
        </a>
    </div>

    <!-- En-tête du praticien -->
    <div class="bg-gradient-to-r from-indigo-600 to-indigo-700 rounded-xl shadow-2xl p-8 text-white">
        <div class="flex items-center">
            <div class="flex-shrink-0 h-24 w-24 bg-white rounded-full flex items-center justify-center shadow-lg">
                <i class="fas fa-user-md text-indigo-600 text-5xl"></i>
            </div>
            <div class="ml-6">
                <h1 class="text-4xl font-bold mb-2">{{ $praticien->nom_complet }}</h1>
                <div class="flex items-center space-x-4">
                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold">
                        <i class="fas fa-id-badge mr-2"></i>
                        ID: {{ $praticien->id }}
                    </span>
                    <span class="px-4 py-2 bg-white bg-opacity-20 rounded-lg text-sm font-semibold">
                        <i class="fas fa-user-tag mr-2"></i>
                        {{ $praticien->typePraticien->libelle ?? $praticien->code_type_praticien }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Informations personnelles -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-indigo-600 pb-2">
                <i class="fas fa-user text-indigo-600 mr-2"></i>
                Informations Personnelles
            </h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>
                        Nom
                    </div>
                    <div class="w-2/3 text-sm text-gray-900 font-medium">{{ $praticien->nom }}</div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-user mr-2 text-indigo-600"></i>
                        Prénom
                    </div>
                    <div class="w-2/3 text-sm text-gray-900 font-medium">{{ $praticien->prenom }}</div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-id-card mr-2 text-indigo-600"></i>
                        Identifiant
                    </div>
                    <div class="w-2/3 text-sm text-gray-900 font-medium">{{ $praticien->username ?? 'N/A' }}</div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-map-marker-alt mr-2 text-indigo-600"></i>
                        Adresse
                    </div>
                    <div class="w-2/3 text-sm text-gray-900">{{ $praticien->adresse }}</div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-city mr-2 text-indigo-600"></i>
                        Ville
                    </div>
                    <div class="w-2/3 text-sm text-gray-900">
                        {{ $praticien->ville->nom ?? 'N/A' }}
                        @if($praticien->ville)
                            <span class="text-gray-500">({{ $praticien->ville->code_postal }})</span>
                        @endif
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-star mr-2 text-indigo-600"></i>
                        Notoriété
                    </div>
                    <div class="w-2/3 text-sm text-gray-900">
                        <span class="px-3 py-1 bg-yellow-100 text-yellow-800 rounded-full font-semibold">
                            {{ $praticien->coef_notoriete }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Informations professionnelles -->
        <div class="bg-white rounded-xl shadow-lg p-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-green-600 pb-2">
                <i class="fas fa-briefcase text-green-600 mr-2"></i>
                Informations Professionnelles
            </h2>
            <div class="space-y-4">
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-user-md mr-2 text-green-600"></i>
                        Type
                    </div>
                    <div class="w-2/3 text-sm">
                        <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-lg font-semibold">
                            {{ $praticien->typePraticien->libelle ?? $praticien->code_type_praticien }}
                        </span>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-building mr-2 text-green-600"></i>
                        Lieu d'exercice
                    </div>
                    <div class="w-2/3 text-sm text-gray-900">{{ $praticien->typePraticien->lieu ?? 'N/A' }}</div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-calendar-plus mr-2 text-green-600"></i>
                        Date d'embauche
                    </div>
                    <div class="w-2/3 text-sm text-gray-900 font-medium">
                        {{ $praticien->date_embauche->format('d/m/Y') }}
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-calendar-alt mr-2 text-green-600"></i>
                        Ancienneté
                    </div>
                    <div class="w-2/3 text-sm">
                        <span class="px-3 py-1 bg-indigo-100 text-indigo-800 rounded-lg font-bold text-lg">
                            {{ $praticien->anciennete }} ans
                        </span>
                    </div>
                </div>
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-layer-group mr-2 text-green-600"></i>
                        Échelon
                    </div>
                    <div class="w-2/3 text-sm">
                        <span class="px-3 py-1 bg-purple-100 text-purple-800 rounded-lg font-bold text-lg">
                            Niveau {{ $praticien->echelon }}
                        </span>
                    </div>
                </div>
                @if($praticien->commentaire)
                <div class="flex items-start">
                    <div class="w-1/3 text-sm font-semibold text-gray-600">
                        <i class="fas fa-comment mr-2 text-green-600"></i>
                        Commentaire
                    </div>
                    <div class="w-2/3 text-sm text-gray-900 italic">{{ $praticien->commentaire }}</div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Informations salariales -->
    <div class="bg-gradient-to-r from-green-500 to-green-600 rounded-xl shadow-2xl p-8 text-white">
        <h2 class="text-3xl font-bold mb-6 flex items-center">
            <i class="fas fa-euro-sign mr-3 text-4xl"></i>
            Informations Salariales
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                <div class="text-sm font-semibold mb-2 opacity-90">Salaire Mensuel</div>
                <div class="text-4xl font-bold">{{ $praticien->salaire_format }}</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                <div class="text-sm font-semibold mb-2 opacity-90">Salaire Annuel Brut</div>
                <div class="text-4xl font-bold">{{ number_format($praticien->salaire * 12, 2, ',', ' ') }} €</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-6 backdrop-blur-sm">
                <div class="text-sm font-semibold mb-2 opacity-90">Échelon Actuel</div>
                <div class="text-4xl font-bold">{{ $praticien->echelon }} / 13</div>
            </div>
        </div>
    </div>

    <!-- Modification de l'ancienneté -->
    @if(Session::get('is_admin'))
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-orange-600 pb-2">
            <i class="fas fa-edit text-orange-600 mr-2"></i>
            Modifier l'ancienneté
        </h2>
        
        <div class="bg-yellow-50 border-l-4 border-yellow-500 p-4 mb-6">
            <div class="flex">
                <i class="fas fa-exclamation-triangle text-yellow-500 text-xl mr-3 mt-1"></i>
                <div>
                    <p class="text-sm text-yellow-700 font-semibold">Attention</p>
                    <p class="text-sm text-yellow-600 mt-1">
                        La modification de la date d'embauche recalculera automatiquement l'ancienneté, l'échelon et le salaire du praticien selon la grille salariale.
                    </p>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('praticiens.update.anciennete', $praticien->id) }}" class="max-w-md">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="date_embauche" class="block text-sm font-semibold text-gray-700 mb-2">
                        <i class="fas fa-calendar mr-2 text-orange-600"></i>
                        Nouvelle date d'embauche
                    </label>
                    <input 
                        type="date" 
                        id="date_embauche"
                        name="date_embauche" 
                        value="{{ $praticien->date_embauche->format('Y-m-d') }}"
                        required
                        max="{{ date('Y-m-d') }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 text-lg font-semibold">
                </div>
                <div>
                    <button 
                        type="submit" 
                        class="w-full bg-orange-600 hover:bg-orange-700 text-white font-bold py-3 px-6 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-save mr-2"></i>
                        Mettre à jour l'ancienneté
                    </button>
                </div>
            </div>
        </form>
    </div>
    @endif
</div>
@endsection