<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ville extends Model
{
    protected $table = 'ville';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nom',
        'code_postal',
        'commune',
        'code_commune',
        'id_departement'
    ];

    // Relations
    public function departement()
    {
        return $this->belongsTo(Departement::class, 'id_departement');
    }

    public function praticiens()
    {
        return $this->hasMany(Praticien::class, 'id_ville');
    }
}