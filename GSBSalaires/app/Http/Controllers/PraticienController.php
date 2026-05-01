<?php

namespace App\Http\Controllers;

use App\Models\Praticien;
use App\Models\TypePraticien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PraticienController extends Controller
{
    // Liste des praticiens avec filtres
    public function index(Request $request)
    {
        $query = Praticien::with(['typePraticien', 'ville']);

        // Filtre par nom/prénom
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nom', 'LIKE', "%{$search}%")
                  ->orWhere('prenom', 'LIKE', "%{$search}%")
                  ->orWhere(DB::raw("CONCAT(prenom, ' ', nom)"), 'LIKE', "%{$search}%");
            });
        }

        // Filtre par type de praticien
        if ($request->filled('type')) {
            $query->where('code_type_praticien', $request->type);
        }

        // Filtre par échelon
        if ($request->filled('echelon')) {
            $query->where('echelon', $request->echelon);
        }

        // Filtre par ancienneté (minimum)
        if ($request->filled('anciennete_min')) {
            $query->where('anciennete', '>=', $request->anciennete_min);
        }

        // Filtre par ancienneté (maximum)
        if ($request->filled('anciennete_max')) {
            $query->where('anciennete', '<=', $request->anciennete_max);
        }

        // Filtre par salaire (minimum)
        if ($request->filled('salaire_min')) {
            $query->where('salaire', '>=', $request->salaire_min);
        }

        // Filtre par salaire (maximum)
        if ($request->filled('salaire_max')) {
            $query->where('salaire', '<=', $request->salaire_max);
        }

        // Tri
        $sortBy = $request->get('sort_by', 'nom');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        // Pagination
        $praticiens = $query->paginate(20)->withQueryString();

        // Récupérer les types de praticiens pour le filtre
        $typesPraticiens = TypePraticien::all();

        return view('praticiens.index', compact('praticiens', 'typesPraticiens'));
    }

    // Afficher un praticien
    public function show($id)
    {
        $praticien = Praticien::with(['typePraticien', 'ville.departement'])->findOrFail($id);
        
        return view('praticiens.show', compact('praticien'));
    }

    // Mettre à jour l'ancienneté
    public function updateAnciennete(Request $request, $id)
    {
        $request->validate([
            'date_embauche' => 'required|date',
        ]);

        $praticien = Praticien::findOrFail($id);
        
        // Mettre à jour la date d'embauche
        // Le trigger SQL recalculera automatiquement l'ancienneté, l'échelon et le salaire
        $praticien->date_embauche = $request->date_embauche;
        $praticien->save();

        // Recharger le praticien pour obtenir les valeurs calculées
        $praticien->refresh();

        return redirect()->route('praticiens.show', $id)
            ->with('success', 'L\'ancienneté a été mise à jour avec succès. Nouvel échelon : ' . $praticien->echelon . ', Nouveau salaire : ' . $praticien->salaire_format);
    }

    // Statistiques
    public function stats()
    {
        $stats = [
            'total' => Praticien::count(),
            'par_type' => Praticien::select('code_type_praticien', DB::raw('count(*) as total'))
                ->groupBy('code_type_praticien')
                ->with('typePraticien')
                ->get(),
            'par_echelon' => Praticien::select('echelon', DB::raw('count(*) as total'))
                ->groupBy('echelon')
                ->orderBy('echelon')
                ->get(),
            'salaire_moyen' => Praticien::avg('salaire'),
            'salaire_total' => Praticien::sum('salaire'),
        ];

        return view('praticiens.stats', compact('stats'));
    }
}