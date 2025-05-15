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
    public function marquerPaiementEffectue($id)
    {
        $model = new ReservationModel();
        $reservation = $model->find($id);

        if (!$reservation) {
            return redirect()->back()->with('error', 'Réservation introuvable.');
        }

        $model->update($id, ['paiementEffectué' => true, 'statut' => 'Confirmée']);

        return redirect()->back()->with('success', 'Le paiement a été marqué comme effectué.');
    }

    // ADMIN : Annuler les réservations non payées à 15 jours avant la date de début
    public function verifierPaiementNonEffectue()
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
    }

    // ADMIN : Voir les réservations d'une maison
    public function adminMaisonReservations($idMaison)
    {
        $model = new ReservationModel();
        $data['reservations'] = $model->where('idMaison', $idMaison)->findAll();
        return view('adminReservations', $data);
    }

    // UTILISATEUR : Signaler un paiement
    public function signalerPaiement($id)
    {
        $model = new ReservationModel();
        $reservation = $model->find($id);

        if (!$reservation || $reservation['idUtilisateur'] != session()->get('idUtilisateur')) {
            return redirect()->back()->with('error', 'Action non autorisée.');
        }

        // Ici on pourrait envoyer un mail à l’admin, ou stocker une notification
        return redirect()->back()->with('success', 'Votre signalement a été pris en compte. Un administrateur va vérifier.');
    }

    // UTILISATEUR : Afficher le formulaire de réservation pour une maison
public function showReservationForm($idMaison)
{
    $maisonModel = new GuesthouseModel();
    $saisonModel = new SaisonModel(); // tu initialises le modèle Saison

    $maison = $maisonModel->find($idMaison);

    if (!$maison) {
        return redirect()->to('/allGuesthouses')->with('error', 'Maison introuvable.');
    }

    // Tu récupères les saisons pour cette maison
    $saisons = $saisonModel->where('idMaison', $idMaison)->findAll();

    // Tu envoies les saisons et la maison à la vue
    return view('reservationForm', [
        'maison' => $maison,
        'saisons' => $saisons,
    ]);
}



    // UTILISATEUR : Créer une réservation via formulaire
    public function createReservation()
    {
        helper('form');
        $validation = \Config\Services::validation();

        $validation->setRules([
            'idMaison' => 'required|integer',
            'idUtilisateur' => 'required|integer',
            'dateDebut' => 'required|valid_date[Y-m-d]',
            'dateFin' => 'required|valid_date[Y-m-d]|is_after[dateDebut]',
            'prix' => 'required|decimal',
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => implode(', ', $validation->getErrors()),
            ]);
        }

        $prixTotal = $this->calculerPrixTotal(
            $this->request->getPost('idMaison'),
            $this->request->getPost('dateDebut'),
            $this->request->getPost('dateFin')
        );

        $data = [
            'idMaison' => $this->request->getPost('idMaison'),
            'idUtilisateur' => $this->request->getPost('idUtilisateur'),
            'dateDebut' => $this->request->getPost('dateDebut'),
            'dateFin' => $this->request->getPost('dateFin'),
            'prix' => $prixTotal,
            'statut' => 'En attente',
            'paiementEffectué' => false,
            'datePaiementPrévu' => date('Y-m-d', strtotime($this->request->getPost('dateDebut').' -15 days')),
        ];

        $reservationModel = new ReservationModel();
        if ($reservationModel->insert($data)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Réservation créée avec succès ! Merci de procéder au paiement.',
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Erreur lors de la création de la réservation.',
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


}