<?php

namespace App\Models;

use CodeIgniter\Model;

class IndisponibiliteModels extends Model
{
    protected $table = 'indisponibilite';
    protected $primaryKey = 'idIndisponibilite';
    protected $returnType = 'array';
    protected $allowedFields = ['idGuesthouse', 'dateDebut', 'dateFin', 'raison'];
}
