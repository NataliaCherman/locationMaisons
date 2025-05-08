<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModels extends Model
{
    protected $table = 'reservation';
    protected $primaryKey = 'idReservation';
    protected $returnType = 'array';
    protected $allowedFields = ['idGuesthouse', 'idUtilisateur', 'dateDebut', 'dateFin', 'statut'];
}

//A modifier encore