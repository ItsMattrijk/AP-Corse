<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TypePraticien extends Model
{
    protected $table = 'type_praticien';
    
    protected $primaryKey = 'code';
    
    public $incrementing = false;
    
    protected $keyType = 'string';
    
    public $timestamps = false;
    
    protected $fillable = [
        'code',
        'libelle',
        'lieu',
        'type'
    ];

    // Relations
    public function praticiens()
    {
        return $this->hasMany(Praticien::class, 'code_type_praticien', 'code');
    }

    public function grilleSalariale()
    {
        return $this->hasMany(GrilleSalariale::class, 'code_type_praticien', 'code');
    }
}