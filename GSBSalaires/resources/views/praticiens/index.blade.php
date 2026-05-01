@extends('layout')

@section('title', 'Liste des Praticiens - GSB')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-indigo-600">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">
                    <i class="fas fa-users text-indigo-600 mr-3"></i>
                    Gestion des Praticiens
                </h1>
                <p class="text-gray-600">{{ $praticiens->total() }} praticien(s) trouvé(s)</p>
            </div>
            <div class="text-right">
                <p class="text-sm text-gray-500">Service des Ressources Humaines</p>
                <p class="text-xs text-gray-400">{{ now()->format('d/m/Y à H:i') }}</p>
            </div>
        </div>
    </div>

    <!-- Filtres -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <form method="GET" action="{{ route('praticiens.index') }}" class="space-y-4">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-semibold text-gray-800">
                    <i class="fas fa-filter text-indigo-600 mr-2"></i>
                    Filtres de recherche
                </h2>
                @if(request()->hasAny(['search', 'type', 'echelon', 'anciennete_min', 'anciennete_max', 'salaire_min', 'salaire_max']))
                    <a href="{{ route('praticiens.index') }}" class="text-sm text-red-600 hover:text-red-800 font-medium">
                        <i class="fas fa-times-circle mr-1"></i>
                        Réinitialiser les filtres
                    </a>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Recherche par nom -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-search mr-1"></i>
                        Nom / Prénom
                    </label>
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Rechercher..."
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Type de praticien -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user-md mr-1"></i>
                        Type de praticien
                    </label>
                    <select 
                        name="type" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les types</option>
                        @foreach($typesPraticiens as $type)
                            <option value="{{ $type->code }}" {{ request('type') == $type->code ? 'selected' : '' }}>
                                {{ $type->libelle }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Échelon -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-layer-group mr-1"></i>
                        Échelon
                    </label>
                    <select 
                        name="echelon" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                        <option value="">Tous les échelons</option>
                        @for($i = 1; $i <= 13; $i++)
                            <option value="{{ $i }}" {{ request('echelon') == $i ? 'selected' : '' }}>
                                Échelon {{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>

                <!-- Ancienneté minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-alt mr-1"></i>
                        Ancienneté min (ans)
                    </label>
                    <input 
                        type="number" 
                        name="anciennete_min" 
                        value="{{ request('anciennete_min') }}"
                        min="0"
                        placeholder="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Ancienneté maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-calendar-check mr-1"></i>
                        Ancienneté max (ans)
                    </label>
                    <input 
                        type="number" 
                        name="anciennete_max" 
                        value="{{ request('anciennete_max') }}"
                        min="0"
                        placeholder="99"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Salaire minimum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-euro-sign mr-1"></i>
                        Salaire min (€)
                    </label>
                    <input 
                        type="number" 
                        name="salaire_min" 
                        value="{{ request('salaire_min') }}"
                        min="0"
                        step="100"
                        placeholder="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Salaire maximum -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-euro-sign mr-1"></i>
                        Salaire max (€)
                    </label>
                    <input 
                        type="number" 
                        name="salaire_max" 
                        value="{{ request('salaire_max') }}"
                        min="0"
                        step="100"
                        placeholder="999999"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <!-- Bouton de recherche -->
                <div class="flex items-end">
                    <button 
                        type="submit" 
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
                        <i class="fas fa-search mr-2"></i>
                        Rechercher
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Tableau des praticiens -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gradient-to-r from-indigo-600 to-indigo-700">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <a href="{{ route('praticiens.index', array_merge(request()->all(), ['sort_by' => 'nom', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}">
                                Nom / Prénom
                                @if(request('sort_by') == 'nom')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">Type</th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <a href="{{ route('praticiens.index', array_merge(request()->all(), ['sort_by' => 'anciennete', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}">
                                Ancienneté
                                @if(request('sort_by') == 'anciennete')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <a href="{{ route('praticiens.index', array_merge(request()->all(), ['sort_by' => 'echelon', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}">
                                Échelon
                                @if(request('sort_by') == 'echelon')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-left text-xs font-semibold text-white uppercase tracking-wider">
                            <a href="{{ route('praticiens.index', array_merge(request()->all(), ['sort_by' => 'salaire', 'sort_order' => request('sort_order') == 'asc' ? 'desc' : 'asc'])) }}">
                                Salaire
                                @if(request('sort_by') == 'salaire')
                                    <i class="fas fa-sort-{{ request('sort_order') == 'asc' ? 'up' : 'down' }} ml-1"></i>
                                @endif
                            </a>
                        </th>
                        <th class="px-6 py-4 text-center text-xs font-semibold text-white uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($praticiens as $praticien)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-full flex items-center justify-center">
                                    <i class="fas fa-user-md text-indigo-600"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-semibold text-gray-900">{{ $praticien->nom_complet }}</div>
                                    <div class="text-xs text-gray-500">ID: {{ $praticien->id }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $praticien->code_type_praticien == 'MH' ? 'bg-blue-100 text-blue-800' : 
                                   ($praticien->code_type_praticien == 'MV' ? 'bg-green-100 text-green-800' : 
                                   ($praticien->code_type_praticien == 'PH' ? 'bg-purple-100 text-purple-800' : 
                                   ($praticien->code_type_praticien == 'PO' ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-800'))) }}">
                                {{ $praticien->typePraticien->libelle ?? $praticien->code_type_praticien }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                            {{ $praticien->anciennete }} ans
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 py-1 text-sm font-semibold bg-indigo-100 text-indigo-800 rounded">
                                Niveau {{ $praticien->echelon }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                            <i class="fas fa-euro-sign text-green-600 mr-1"></i>
                            {{ $praticien->salaire_format }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-center text-sm font-medium">
                            <a href="{{ route('praticiens.show', $praticien->id) }}" 
                               class="inline-flex items-center px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg transition-colors duration-200 shadow-sm hover:shadow-md">
                                <i class="fas fa-eye mr-2"></i>
                                Détails
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <i class="fas fa-search text-gray-400 text-6xl mb-4"></i>
                                <p class="text-gray-500 text-lg font-medium">Aucun praticien trouvé</p>
                                <p class="text-gray-400 text-sm mt-2">Essayez de modifier vos critères de recherche</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($praticiens->hasPages())
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            {{ $praticiens->links() }}
        </div>
        @endif
    </div>
</div>
@endsection