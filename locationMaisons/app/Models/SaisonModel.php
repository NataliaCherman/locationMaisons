<?php

namespace App\Models;

use CodeIgniter\Model;

class SaisonModel extends Model
{
    protected $table = 'Saison';
    protected $primaryKey = 'idSaison';
    protected $allowedFields = ['annee', 'typeSaison', 'dateDebut', 'dateFin', 'idMaison', 'prix'];
}