<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GrilleSalariale extends Model
{
    protected $table = 'grille_salariale';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code_type_praticien',
        'echelon',
        'anciennete_min',
        'anciennete_max',
        'salaire'
    ];

    protected $casts = [
        'echelon' => 'integer',
        'anciennete_min' => 'integer',
        'anciennete_max' => 'integer',
        'salaire' => 'float',
    ];

    // Relations
    public function typePraticien()
    {
        return $this->belongsTo(TypePraticien::class, 'code_type_praticien', 'code');
    }

    public function praticiens()
    {
        return $this->hasMany(Praticien::class, 'echelon', 'echelon')
                    ->where('code_type_praticien', $this->code_type_praticien);
    }
}