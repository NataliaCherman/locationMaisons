<?php namespace App\Models;

use CodeIgniter\Model;
use App\Models\ReservationModel;

class IndisponibiliteModel extends Model
{
    protected $table = 'Indisponibilite';
    protected $primaryKey = 'idIndisponibilite';
    protected $returnType = 'array';
    protected $allowedFields = ['idMaison', 'dateDebut', 'dateFin', 'motif', 'creeParAdmin'];

    // Règles de validation
    protected $validationRules = [
        'idMaison'   => 'required|is_natural_no_zero', // Assurer que l'ID de la maison est valide
        'motif'      => 'required|string|min_length[3]',  // Le motif doit être une chaîne non vide d'au moins 3 caractères
        'dateDebut'  => 'required|valid_date',  // La date de début doit être une date valide
        'dateFin'    => 'required|valid_date',  // La date de fin doit être une date valide
    ];

    protected $validationMessages = [
        'idMaison' => [
            'required' => 'L\'ID de la maison est requis.',
            'is_natural_no_zero' => 'L\'ID de la maison doit être un entier supérieur à zéro.',
        ],
        'motif' => [
            'required' => 'Le motif est requis.',
            'string' => 'Le motif doit être une chaîne de caractères.',
            'min_length' => 'Le motif doit contenir au moins 3 caractères.',
        ],
        'dateDebut' => [
            'required' => 'La date de début est requise.',
            'valid_date' => 'La date de début doit être une date valide.',
        ],
        'dateFin' => [
            'required' => 'La date de fin est requise.',
            'valid_date' => 'La date de fin doit être une date valide.',
        ],
    ];

    /*public function isMaisonDisponible($idMaison, $dateDebut, $dateFin)
    {
        return !$this->where('idMaison', $idMaison)
                    ->groupStart()
                        ->where('dateDebut <=', $dateFin)
                        ->where('dateFin >=', $dateDebut)
                    ->groupEnd()
                    ->first();
    }*/

    public function isMaisonDisponible(int $idMaison, string $dateDebut, string $dateFin): bool
    {
        // Vérifier les indisponibilités
        $indispoCount = $this->where('idMaison', $idMaison)
            ->groupStart()
                ->where('dateDebut <=', $dateFin)
                ->where('dateFin >=', $dateDebut)
            ->groupEnd()
            ->countAllResults();

        if ($indispoCount > 0) {
            return false;
        }

        // Charger le modèle Reservation
        $reservationModel = new ReservationModel();

        // Vérifier les réservations confirmées ou en attente
        $reservationCount = $reservationModel->where('idMaison', $idMaison)
            ->whereIn('statut', ['Confirmée', 'En attente'])
            ->groupStart()
                ->where('dateDebut <=', $dateFin)
                ->where('dateFin >=', $dateDebut)
            ->groupEnd()
            ->countAllResults();

        if ($reservationCount > 0) {
            return false;
        }

        return true;
    }

}