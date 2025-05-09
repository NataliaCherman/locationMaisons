<?php

namespace App\Controllers;

use App\Models\IndisponibiliteModel;
use App\Models\GuesthouseModel;

class IndisponibiliteController extends BaseController
{
    protected $indisponibiliteModel;
    protected $guesthouseModel;

    public function __construct()
    {
        $this->indisponibiliteModel = new IndisponibiliteModel();
        $this->guesthouseModel = new GuesthouseModel();
    }

    public function index($idMaison)
    {
        // On récupère la maison (facultatif si tu ne l'utilises pas dans la vue)
        $guesthouse = $this->guesthouseModel->find($idMaison);
    
        // On récupère les indisponibilités associées à cette maison
        $indisponibilites = $this->indisponibiliteModel
            ->where('idMaison', $idMaison)
            ->findAll();
    
        // On passe tout à la vue
        return view('allIndisponibilites', [
            'idMaison' => $idMaison,
            'titre' => $guesthouse['titre'],
            'indisponibilites' => $indisponibilites
        ]);
    }
    
    public function create($idMaison)
    {
        // Charger les modèles nécessaires
        $guesthouseModel = new GuesthouseModel();
        $indisponibiliteModel = new IndisponibiliteModel();
    
        // Récupérer les informations de la maison
        $guesthouse = $guesthouseModel->find($idMaison);
        if (!$guesthouse) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Maison non trouvée");
        }
    
        // Récupérer les indisponibilités associées à cette maison
        $indisponibilites = $indisponibiliteModel->where('idMaison', $idMaison)->findAll();
    
        // Passer les données à la vue
        return view('createIndisponibilite', [
            'idMaison' => $idMaison,
            'guesthouse' => $guesthouse, // Les détails de la maison
            'indisponibilites' => $indisponibilites // Les indisponibilités existantes
        ]);
    }
    


    // Enregistre l'indisponibilité (exemple de logique POST)
    public function store()
    {
        $data = $this->request->getPost();

        $this->indisponibiliteModel->insert([
            'idMaison' => $data['idMaison'],
            'motif'    => $data['motif'],
            'dateDebut' => $data['dateDebut'],
            'dateFin'   => $data['dateFin'],
        ]);

        return redirect()->to('/allGuesthouses')->with('success', 'Indisponibilité ajoutée');
    }


    public function delete($idIndisponibilite)
{
    $indisponibiliteModel = new IndisponibiliteModel();

    // Vérifier si l'indisponibilité existe
    $indisponibilite = $indisponibiliteModel->find($idIndisponibilite);

    if ($indisponibilite) {
        // Suppression de l'indisponibilité
        $indisponibiliteModel->delete($idIndisponibilite);
        return redirect()->to('/allGuesthouses')->with('success', 'Indisponibilité supprimée avec succès.');
    } else {
        return redirect()->to('/allIndisponibilites')->with('error', 'Indisponibilité non trouvée.');
    }
}

}
