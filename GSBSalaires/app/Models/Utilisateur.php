<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    protected $table = 'utilisateur';
    
    public $timestamps = false;
    
    protected $fillable = [
        'nom',
        'mdp',
        'isAdmin',
        'commentaire'
    ];

    protected $hidden = [
        'mdp',
    ];

    // Vérifier si l'utilisateur est admin
    public function isAdmin()
    {
        return $this->isAdmin == 1;
    }

    // Vérifier le mot de passe
    public function checkPassword($password)
    {
        // Le mot de passe dans la BDD est hashé avec sha256 + hmac
        // D'après le commentaire dans la BDD : "MDP : M3Adm2025! , sha(256)+hmac"
        // Le hash stocké est : 7b19f378770e3cde68b06063d58fe5b87caf29027ea672eb621dc2e540dd474c
        
        // Essayer avec HMAC
        $hashedPassword = hash_hmac('sha256', $password, config('app.key'));
        if ($this->mdp === $hashedPassword) {
            return true;
        }
        
        // Essayer avec SHA256 simple (sans HMAC)
        $simpleHash = hash('sha256', $password);
        if ($this->mdp === $simpleHash) {
            return true;
        }
        
        // Essayer une comparaison directe (pour les comptes de test)
        if ($this->mdp === $password) {
            return true;
        }
        
        return false;
    }
}