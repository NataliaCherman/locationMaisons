<?php namespace App\Models;
use CodeIgniter\Model;

class IndisponibiliteModel extends Model
{
    protected $table = 'Indisponibilite';
    protected $primaryKey = 'idIndisponibilite';
    protected $returnType = 'array';
    protected $allowedFields = ['idMaison', 'dateDebut', 'dateFin', 'motif', 'creeParAdmin'];
}