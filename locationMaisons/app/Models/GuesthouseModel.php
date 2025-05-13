<?php namespace App\Models;
use CodeIgniter\Model;

class GuesthouseModel extends Model
{
    protected $table = 'Guesthouses';
    protected $primaryKey = 'idGuesthouse';
    protected $returnType = 'array';
    protected $allowedFields = ['titre', 'detail', 'village', 'pays', 'photos', 'attractions'];

    // Méthode pour vérifier l'unicité du titre avant d'ajouter une maison d'hôte
    public function checkTitleUnique($title)
    {
        return $this->where('titre', $title)->first() === null;
    }
}