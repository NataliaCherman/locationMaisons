<?php

namespace App\Controllers;

use App\Models\IndisponibiliteModels;
use App\Models\HouseModels;
use CodeIgniter\Controller;

class IndisponibiliteController extends Controller
{
    protected $indisponibiliteModel;

    public function __construct() {
        $this->indisponibiliteModel = new IndisponibiliteModel();
    }

    public function createIndisponibilite() {
        $guesthouseModel = new GuesthouseModel();
        $guesthouses = $guesthouseModel->findAll();

        return view('CreateIndisponibilites', ['guesthouses' => $guesthouses]);
    }

    public function save() {
        $data = [
            'idGuesthouse' => $this->request->getPost('idGuesthouse'),
            'dateDebut' => $this->request->getPost('dateDebut'),
            'dateFin' => $this->request->getPost('dateFin'),
            'raison' => $this->request->getPost('raison')
        ];

        $this->indisponibiliteModel->insert($data);

        return redirect()->to(base_url('indisponibilites/all'))->with('success', 'Indisponibilité enregistrée avec succès');
    }

    public function allIndisponibilites() {
        $indisponibilites = $this->indisponibiliteModel->findAll();

        return view('AllIndisponibilites', ['indisponibilites' => $indisponibilites]);
    }

    public function edit($id) {
        $indisponibilite = $this->indisponibiliteModel->find($id);

        if (!$indisponibilite) {
            return redirect()->to('/indisponibilites/all')->with('error', 'Indisponibilité non trouvée.');
        }

        return view('EditIndisponibilite', ['indisponibilite' => $indisponibilite]);
    }

    public function update($id) {
        $this->indisponibiliteModel->update($id, [
            'idGuesthouse' => $this->request->getPost('idGuesthouse'),
            'dateDebut' => $this->request->getPost('dateDebut'),
            'dateFin' => $this->request->getPost('dateFin'),
            'raison' => $this->request->getPost('raison'),
        ]);

        return redirect()->to(base_url('indisponibilites/all'))->with('success', 'Indisponibilité mise à jour.');
    }

    public function delete($id) {
        $this->indisponibiliteModel->delete($id);

        return redirect()->to(base_url('indisponibilites/all'))->with('success', 'Indisponibilité supprimée.');
    }
}
