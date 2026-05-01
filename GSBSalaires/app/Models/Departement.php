<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departement extends Model
{
    protected $table = 'departement';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'nom',
        'commune',
        'id_region'
    ];

    // Relations
    public function region()
    {
        return $this->belongsTo(Region::class, 'id_region');
    }

    public function villes()
    {
        return $this->hasMany(Ville::class, 'id_departement');
    }
}