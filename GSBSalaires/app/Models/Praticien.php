<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Praticien extends Model
{
    protected $table = 'praticien';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nom',
        'prenom',
        'date_embauche',
        'anciennete',
        'echelon',
        'adresse',
        'coef_notoriete',
        'salaire',
        'code_type_praticien',
        'id_ville',
        'username',
        'mdp',
        'commentaire'
    ];

    protected $casts = [
        'date_embauche' => 'date',
        'anciennete' => 'integer',
        'echelon' => 'integer',
        'coef_notoriete' => 'float',
        'salaire' => 'float',
    ];

    // Relations
    public function typePraticien()
    {
        return $this->belongsTo(TypePraticien::class, 'code_type_praticien', 'code');
    }

    public function ville()
    {
        return $this->belongsTo(Ville::class, 'id_ville');
    }

    public function grilleSalariale()
    {
        return $this->hasOne(GrilleSalariale::class, 'code_type_praticien', 'code_type_praticien')
                    ->where('echelon', $this->echelon);
    }

    // Accesseurs
    public function getNomCompletAttribute()
    {
        return $this->prenom . ' ' . $this->nom;
    }

    public function getSalaireFormatAttribute()
    {
        return number_format($this->salaire, 2, ',', ' ') . ' €';
    }
}