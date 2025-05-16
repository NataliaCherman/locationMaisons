<?php
namespace App\Controllers;

use App\Models\ReservationModel;
use App\Models\SaisonModel;
use App\Models\GuesthouseModel;
use CodeIgniter\Controller;
use CodeIgniter\I18n\Time;

class ReservationController extends BaseController
{
    // ADMIN : Marquer une réservation comme payée
    /*public function marquerPaiementEffectue($id)
    {
        $model = new ReservationModel();
        $reservation = $model->find($id);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $model->update($id, ['paiementEffectué' => true, 'statut' => 'Confirmée']);

        return redirect()->back()->with('success', 'Le paiement a été marqué comme effectué.');
    }*/

    // ADMIN : Annuler les réservations non payées à 15 jours avant la date de début
    /*public function verifierPaiementNonEffectue()
    {
        $model = new ReservationModel();
        $today = Time::now();
        $limitDate = $today->addDays(15)->toDateString();

        $reservations = $model
            ->where('paiementEffectué', false)
            ->where('dateDebut <=', $limitDate)
            ->where('statut !=', 'Annulée')
            ->findAll();

        foreach ($reservations as $res) {
            $model->update($res['idReservation'], ['statut' => 'Annulée']);
        }

        return redirect()->back()->with('success', 'Vérification terminée. Réservations annulées si non payées.');
    }*/

    // ADMIN : Voir les réservations d'une maison
    public function adminMaisonReservations($idMaison)
    {
        $model = new ReservationModel();
        $data['reservations'] = $model->where('idMaison', $idMaison)->findAll();
        return view('adminReservations', $data);
    }

    // UTILISATEUR : Signaler un paiement
    /*public function signalerPaiement($id)
    {
        $model = new ReservationModel();
        $reservation = $model->find($id);

        if (!$reservation || $reservation['idUtilisateur'] != session()->get('idUtilisateur')) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        // Ici on pourrait envoyer un mail à l’admin, ou stocker une notification
        return redirect()->back()->with('success', 'Votre signalement a été pris en compte. Un administrateur va vérifier.');
    }*/

    // UTILISATEUR : Afficher le formulaire de réservation pour une maison
    public function showReservationForm($idMaison)
    {
        $maisonModel = new GuesthouseModel();
        $saisonModel = new SaisonModel();

        $maison = $maisonModel->find($idMaison);

        // Récupération des données liées aux saisons
        $saisons = $saisonModel->where('idMaison', $idMaison)->findAll();

        return view('reservationForm', [
            'maison' => $maison,
            'saisons' => $saisons,
        ]);
    }


    // UTILISATEUR : Créer une réservation via formulaire
    /*public function createReservation()
    {
        helper('form');


        $validation = \Config\Services::validation();

        $validation->setRules([
            'idMaison' => 'required|integer',
            'idUtilisateur' => 'required|integer',
            'dateDebut' => 'required|valid_date[Y-m-d]',
            'dateFin' => 'required|valid_date[Y-m-d]',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => implode(', ', array_values($validation->getErrors())),
            ]);
        }


        $idMaison = $this->request->getPost('idMaison');
        $idUtilisateur = $this->request->getPost('idUtilisateur');
        $dateDebut = $this->request->getPost('dateDebut');
        $dateFin = $this->request->getPost('dateFin');

        // Vérification que dateFin > dateDebut
        if (strtotime($dateFin) <= strtotime($dateDebut)) {
            return $this->response->setStatusCode(400)->setJSON([
                'success' => false,
                'message' => 'La date de fin doit être postérieure à la date de début.',
            ]);
        }

        // Calcul du prix total
        $prixTotal = $this->calculerPrixTotal($idMaison, $dateDebut, $dateFin);

        // Préparation des données pour insertion
        $data = [
            'idMaison' => $idMaison,
            'idUtilisateur' => $idUtilisateur,
            'dateDebut' => $dateDebut,
            'dateFin' => $dateFin,
            'prix' => $prixTotal,
            'statut' => 'En attente',
            'paiementEffectué' => false,
            'datePaiementPrévu' => date('Y-m-d', strtotime($dateDebut . ' -15 days')),
        ];

        // Insertion dans la base de données
        $reservationModel = new \App\Models\ReservationModel();
        if ($reservationModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Réservation créée avec succès ! Merci de procéder au paiement.',
            ]);
        } else {
            // Log de l’erreur pour debugging
            log_message('error', 'Erreur création réservation : ' . json_encode($reservationModel->errors()));

            return $this->response->setStatusCode(500)->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la création de la réservation. Veuillez réessayer plus tard.',
            ]);
        }
    }*/
/*public function createReservation()
{
    helper('form');
    $validation = \Config\Services::validation();

    $validation->setRules([
        'idMaison' => 'required|integer',
        'idUtilisateur' => 'required|integer',
        'dateDebut' => 'required|valid_date[Y-m-d]',
        'dateFin' => 'required|valid_date[Y-m-d]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => implode(', ', array_values($validation->getErrors())),
        ]);
    }

    $idMaison = $this->request->getPost('idMaison');
    $idUtilisateur = $this->request->getPost('idUtilisateur');
    $dateDebut = $this->request->getPost('dateDebut');
    $dateFin = $this->request->getPost('dateFin');

    // Vérifie que dateDebut < dateFin (refuse aussi les dates identiques)
    if (strtotime($dateFin) <= strtotime($dateDebut)) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'La date de fin doit être postérieure à la date de début.',
        ]);
    }

    $reservationModel = new \App\Models\ReservationModel();
    $indisponibiliteModel = new \App\Models\IndisponibiliteModel();

    // Vérifie qu'aucune réservation existante ne chevauche la période demandée (hors statut Annulée)
    $existingReservation = $reservationModel
        ->where('idMaison', $idMaison)
        ->where('statut !=', 'Annulée')
        ->groupStart()
            ->where('dateDebut <=', $dateFin)
            ->where('dateFin >=', $dateDebut)
        ->groupEnd()
        ->first();

    if ($existingReservation) {
        return $this->response->setStatusCode(409)->setJSON([
            'success' => false,
            'message' => 'La maison est déjà réservée sur cette période.',
        ]);
    }

    // Vérifie qu'il n'y a pas d'indisponibilité admin
    $indispo = $indisponibiliteModel
        ->where('idMaison', $idMaison)
        ->groupStart()
            ->where('dateDebut <=', $dateFin)
            ->where('dateFin >=', $dateDebut)
        ->groupEnd()
        ->first();

    if ($indispo) {
        return $this->response->setStatusCode(409)->setJSON([
            'success' => false,
            'message' => 'La maison est indisponible pour cette période (indisponibilité définie par l\'admin).',
        ]);
    }

    // Calcul du prix total
    $prixTotal = $this->calculerPrixTotal($idMaison, $dateDebut, $dateFin);

    // Préparation des données
    $data = [
        'idMaison' => $idMaison,
        'idUtilisateur' => $idUtilisateur,
        'dateDebut' => $dateDebut,
        'dateFin' => $dateFin,
        'prix' => $prixTotal,
        'statut' => 'En attente',
        'paiementEffectué' => false,
        'datePaiementPrévu' => date('Y-m-d', strtotime($dateDebut . ' -15 days')),
    ];

    if ($reservationModel->insert($data)) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Réservation créée avec succès ! Merci de procéder au paiement.',
        ]);
    } else {
        log_message('error', 'Erreur création réservation : ' . json_encode($reservationModel->errors()));

        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Erreur lors de la création de la réservation. Veuillez réessayer plus tard.',
        ]);
    }
}*/
public function createReservation()
{
    helper('form');
    $validation = \Config\Services::validation();

    $validation->setRules([
        'idMaison' => 'required|integer',
        'idUtilisateur' => 'required|integer',
        'dateDebut' => 'required|valid_date[Y-m-d]',
        'dateFin' => 'required|valid_date[Y-m-d]',
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => implode(', ', array_values($validation->getErrors())),
        ]);
    }

    $idMaison = $this->request->getPost('idMaison');
    $idUtilisateur = $this->request->getPost('idUtilisateur');
    $dateDebut = $this->request->getPost('dateDebut');
    $dateFin = $this->request->getPost('dateFin');

    // Vérification que dateFin > dateDebut
    if (strtotime($dateFin) <= strtotime($dateDebut)) {
        return $this->response->setStatusCode(400)->setJSON([
            'success' => false,
            'message' => 'La date de fin doit être postérieure à la date de début.',
        ]);
    }

    // Interdire les réservations d'une seule journée (dateDébut == dateFin)
    if ($dateDebut === $dateFin) {
        return $this->response->setStatusCode(409)->setJSON([
            'success' => false,
            'message' => 'La réservation doit couvrir au moins deux jours. Une réservation d\'un seul jour n\'est pas autorisée.',
        ]);
    }


    $reservationModel = new \App\Models\ReservationModel();
    $indisponibiliteModel = new \App\Models\IndisponibiliteModel();

    // Vérification des conflits avec les indisponibilités admin
$indisponibiliteExistante = $indisponibiliteModel
    ->where('idMaison', $idMaison)
    ->groupStart()
        ->where('dateDebut <=', $dateFin)
        ->where('dateFin >=', $dateDebut)
    ->groupEnd()
    ->first();

if ($indisponibiliteExistante) {
    return $this->response->setStatusCode(409)->setJSON([
        'success' => false,
        'message' => 'Impossible de réserver : cette période est bloquée par l’administration.',
    ]);
}

    // Vérification des conflits avec d'autres réservations
$reservationExistante = $reservationModel
    ->where('idMaison', $idMaison)
    ->groupStart()
        ->where('dateDebut <=', $dateFin)
        ->where('dateFin >=', $dateDebut)
    ->groupEnd()
    ->first();

if ($reservationExistante) {
    return $this->response->setStatusCode(409)->setJSON([
        'success' => false,
        'message' => 'Impossible de réserver : cette période est déjà réservée par un autre utilisateur.',
    ]);
}


    // Calcul du prix
    $prixTotal = $this->calculerPrixTotal($idMaison, $dateDebut, $dateFin);

    // Données à insérer
    $data = [
        'idMaison' => $idMaison,
        'idUtilisateur' => $idUtilisateur,
        'dateDebut' => $dateDebut,
        'dateFin' => $dateFin,
        'prix' => $prixTotal,
        'statut' => 'En attente',
        'paiementEffectué' => false,
        'datePaiementPrévu' => date('Y-m-d', strtotime($dateDebut . ' -15 days')),
    ];

    if ($reservationModel->insert($data)) {
        return $this->response->setJSON([
            'success' => true,
            'message' => 'Réservation créée avec succès ! Merci de procéder au paiement.',
        ]);
    } else {
        log_message('error', 'Erreur création réservation : ' . json_encode($reservationModel->errors()));
        return $this->response->setStatusCode(500)->setJSON([
            'success' => false,
            'message' => 'Erreur lors de la création de la réservation. Veuillez réessayer plus tard.',
        ]);
    }
}





    public function calculerPrixTotal($idMaison, $dateDebut, $dateFin)
    {
        $saisonModel = new \App\Models\SaisonModel();
        $maisonModel = new \App\Models\GuesthouseModel();

        $maison = $maisonModel->find($idMaison);
        if (!$maison) {
            return 0; // Ou gérer l’erreur
        }

        $prixParDefaut = $maison['prixParNuit'];
        $saisons = $saisonModel->where('idMaison', $idMaison)->findAll();

        $total = 0;
        $current = strtotime($dateDebut);
        $end = strtotime($dateFin);

        while ($current < $end) {
            $jour = date('Y-m-d', $current);
            $prixJour = $prixParDefaut;

            foreach ($saisons as $saison) {
                if ($jour >= $saison['dateDebut'] && $jour <= $saison['dateFin']) {
                    $prixJour = $saison['prix'];
                    break;
                }
            }

            $total += $prixJour;
            $current = strtotime('+1 day', $current);
        }

        return $total;
    }

    public function calculerPrixAjax()
    {
        $idMaison = $this->request->getPost('idMaison');
        $dateDebut = $this->request->getPost('dateDebut');
        $dateFin = $this->request->getPost('dateFin');

        if (!$idMaison || !$dateDebut || !$dateFin) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Données manquantes'
            ]);
        }

        $prixTotal = $this->calculerPrixTotal($idMaison, $dateDebut, $dateFin);

        return $this->response->setJSON([
            'success' => true,
            'prix' => number_format($prixTotal, 2, ',', ' ')
        ]);
    }



    public function datesBloquees($idMaison)
{
    $reservationModel = new \App\Models\ReservationModel();
    $indispoModel = new \App\Models\IndisponibiliteModel();

    // Récupérer toutes les plages de réservation
    $reservations = $reservationModel->where('idMaison', $idMaison)
        ->whereIn('statut', ['Confirmée', 'En attente']) // On bloque même les en attente
        ->findAll();

    $indispos = $indispoModel->where('idMaison', $idMaison)->findAll();

    $plages = [];

    foreach ($reservations as $res) {
        $plages[] = [
            'start' => $res['dateDebut'],
            'end'   => date('Y-m-d', strtotime($res['dateFin'] . ' -1 day')) // Flatpickr est exclusif
        ];
    }

    foreach ($indispos as $indispo) {
        $plages[] = [
            'start' => $indispo['dateDebut'],
            'end'   => date('Y-m-d', strtotime($indispo['dateFin'] . ' -1 day'))
        ];
    }

    return $this->response->setJSON($plages);
}

}