@extends('layout')

@section('title', 'Statistiques - GSB')

@section('content')
<div class="space-y-6">
    <!-- En-tête -->
    <div class="bg-white rounded-xl shadow-lg p-6 border-l-4 border-purple-600">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">
            <i class="fas fa-chart-bar text-purple-600 mr-3"></i>
            Statistiques des Praticiens
        </h1>
        <p class="text-gray-600">Analyse globale du personnel médical</p>
    </div>

    <!-- Statistiques globales -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <!-- Total praticiens -->
        <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold opacity-90 mb-2">Total Praticiens</p>
                    <p class="text-5xl font-bold">{{ number_format($stats['total'], 0, ',', ' ') }}</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-users text-5xl"></i>
                </div>
            </div>
        </div>

        <!-- Salaire moyen -->
        <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold opacity-90 mb-2">Salaire Moyen</p>
                    <p class="text-4xl font-bold">{{ number_format($stats['salaire_moyen'], 2, ',', ' ') }} €</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-euro-sign text-5xl"></i>
                </div>
            </div>
        </div>

        <!-- Masse salariale -->
        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl shadow-lg p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold opacity-90 mb-2">Masse Salariale Mensuelle</p>
                    <p class="text-3xl font-bold">{{ number_format($stats['salaire_total'], 2, ',', ' ') }} €</p>
                    <p class="text-xs opacity-75 mt-2">Annuel: {{ number_format($stats['salaire_total'] * 12, 2, ',', ' ') }} €</p>
                </div>
                <div class="bg-white bg-opacity-20 rounded-full p-4">
                    <i class="fas fa-coins text-5xl"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Répartition par type -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-indigo-600 pb-2">
            <i class="fas fa-user-md text-indigo-600 mr-2"></i>
            Répartition par Type de Praticien
        </h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($stats['par_type'] as $type)
            <div class="border-2 border-gray-200 rounded-lg p-4 hover:border-indigo-500 hover:shadow-md transition-all duration-200">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <h3 class="text-sm font-semibold text-gray-700 mb-1">
                            {{ $type->typePraticien->libelle ?? 'Non défini' }}
                        </h3>
                        <p class="text-xs text-gray-500">{{ $type->typePraticien->lieu ?? '' }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-3xl font-bold text-indigo-600">{{ $type->total }}</p>
                        <p class="text-xs text-gray-500">
                            {{ number_format(($type->total / $stats['total']) * 100, 1) }}%
                        </p>
                    </div>
                </div>
                <!-- Barre de progression -->
                <div class="mt-3 bg-gray-200 rounded-full h-2">
                    <div class="bg-indigo-600 h-2 rounded-full" 
                         style="width: {{ ($type->total / $stats['total']) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Répartition par échelon -->
    <div class="bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-2xl font-bold text-gray-900 mb-6 border-b-2 border-green-600 pb-2">
            <i class="fas fa-layer-group text-green-600 mr-2"></i>
            Répartition par Échelon
        </h2>
        <div class="overflow-x-auto">
            <table class="min-w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Échelon
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Nombre de praticiens
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Pourcentage
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">
                            Visualisation
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $maxEchelon = $stats['par_echelon']->max('total');
                    @endphp
                    @foreach($stats['par_echelon'] as $echelon)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 bg-green-100 text-green-800 rounded-lg font-bold">
                                Niveau {{ $echelon->echelon }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-lg font-bold text-gray-900">
                            {{ $echelon->total }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ number_format(($echelon->total / $stats['total']) * 100, 1) }}%
                        </td>
                        <td class="px-6 py-4">
                            <div class="w-full bg-gray-200 rounded-full h-4">
                                <div class="bg-gradient-to-r from-green-400 to-green-600 h-4 rounded-full flex items-center justify-end pr-2" 
                                     style="width: {{ ($echelon->total / $maxEchelon) * 100 }}%">
                                    <span class="text-xs font-bold text-white">{{ $echelon->total }}</span>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Bouton retour -->
    <div class="flex justify-center">
        <a href="{{ route('praticiens.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-lg transition-colors duration-200 shadow-md hover:shadow-lg">
            <i class="fas fa-arrow-left mr-2"></i>
            Retour à la liste des praticiens
        </a>
    </div>
</div>
@endsection