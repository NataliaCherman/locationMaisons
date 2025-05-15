<?php

namespace App\Models;

use CodeIgniter\Model;

class ReservationModel extends Model
{
    protected $table = 'Reservation';
    protected $primaryKey = 'idReservation';
    protected $returnType = 'array';
    protected $allowedFields = [
        'idMaison', 'idUtilisateur', 'dateDebut', 'dateFin', 'statut',
        'datePaiementPrévu', 'paiementEffectué', 'prix'
    ];
}