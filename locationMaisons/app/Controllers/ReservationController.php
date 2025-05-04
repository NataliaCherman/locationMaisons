<?php
namespace App\Controllers;

use App\Models\ReservationModels;
use App\Models\UserModels;
use App\Models\HouseModels;
use App\Models\IndisponibiliteModels;

class ReservationController extends BaseController
{
    public function showReservation() {
        return view('reserveGuesthouse');
    }

    public function createReservation() {
        $userModel = new UserModel();
        $guesthouseModel = new guesthouseModel();

        $data['utilisateur'] = $userModel->findAll();
        $data['guesthouses'] = $maisonModel->findAll();

        return view('reserveGuesthouse', $data);
    }

    public function saveReservation() {
        $reservationModel = new ReservationModel();
        $userModel = new UserModel();
        $guesthouseModel = new guesthouseModel();
        $indisponibiliteModel = new IndisponibiliteModel(); 

        $data = [
            'idUtilisateur'   => $this->request->getPost('idUtilisateur'),
            'idGuesthouse' => $this->request->getPost('idGuesthouse'),
            'dateDebut'     => $this->request->getPost('dateDebut'),
            'dateFin'       => $this->request->getPost('dateFin'),
            'statut'    => $this->request->getPost('statut'),
        ];

        $idGuesthouse = $data['idGuesthouse'];
        $dateDebut = $data['dateDebut'];
        $dateFin = $data['dateFin'];

        $reservationsExistantes = $reservationModel->where('idGuesthouse', $idGuesthouse)
                                                   ->where('dateDebut <', $dateFin)
                                                   ->where('dateFin >', $dateDebut)
                                                   ->findAll();

        if (!empty($reservationsExistantes)) {
            return redirect()->back()->with('error', 'La période que vous avez sélectionnée chevauche une réservation existante pour cette maison.');
        }

        $indisponibilites = $indisponibiliteModel->where('idGuesthouse', $idGuesthouse)
                                                 ->where('dateDebut <', $dateFin)
                                                 ->where('dateFin >', $dateDebut)
                                                 ->findAll();

        if (!empty($indisponibilites)) {
            return redirect()->back()->with('error', 'La période que vous avez sélectionnée chevauche une indisponibilité pour cette maison.');
        }

        $reservationModel->save($data);

        $user = $userModel->find($data['idUtilisateur']);
        $guesthouse = $guesthouseModel->find($data['idGuesthouse']);

        $data['nom'] = $user['nom'];
        $data['prenom'] = $user['prenom'];
        $data['email'] = $user['email'];
        $data['titre'] = $guesthouse['titre'];

        return view('ReservationRecap', $data);
    }
}
