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
        // Récupérer la maison
        $guesthouse = $this->guesthouseModel->find($idMaison);  // Utilisation de 'idMaison'

        if (!$guesthouse) {
            return redirect()->to('/allGuesthouses')->with('error', 'Maison introuvable');
        }

        // Récupérer les indisponibilités associées à cette maison
        $indisponibilites = $this->indisponibiliteModel
            ->where('idMaison', $idMaison)  // Utilisation de 'idMaison'
            ->findAll();

        // Passer tout à la vue
        return view('allIndisponibilites', [
            'idMaison' => $idMaison,  // Utilisation de 'idMaison'
            'titre' => $guesthouse['titre'],
            'indisponibilites' => $indisponibilites
        ]);
    }

    public function create($idMaison)
    {
        // Récupérer les informations de la maison
        $guesthouse = $this->guesthouseModel->find($idMaison);  // Utilisation de 'idMaison'

        if (!$guesthouse) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Maison non trouvée");
        }

        // Récupérer les indisponibilités associées à cette maison
        $indisponibilites = $this->indisponibiliteModel->where('idMaison', $idMaison)->findAll();  // Utilisation de 'idMaison'

        // Passer les données à la vue
        return view('createIndisponibilite', [
            'idMaison' => $idMaison,  // Utilisation de 'idMaison'
            'guesthouse' => $guesthouse, // Les détails de la maison
            'indisponibilites' => $indisponibilites // Les indisponibilités existantes
        ]);
    }

    // Enregistre l'indisponibilité (exemple de logique POST)
    /*public function store()
    {
        $data = $this->request->getPost();

        // Validation des données de l'indisponibilité
        if (empty($data['idMaison']) || empty($data['motif']) || empty($data['dateDebut']) || empty($data['dateFin'])) {
            return redirect()->back()->withInput()->with('error', 'Tous les champs sont obligatoires.');
        }

        // Vérification des dates (date de début doit être antérieure à la date de fin)
        if (strtotime($data['dateDebut']) > strtotime($data['dateFin'])) {
            return redirect()->back()->withInput()->with('error', 'La date de début doit être antérieure à la date de fin.');
        }

        // Enregistrement de l'indisponibilité
        $this->indisponibiliteModel->insert([
            'idMaison' => $data['idMaison'],
            'motif'    => $data['motif'],
            'dateDebut' => $data['dateDebut'],
            'dateFin'   => $data['dateFin'],
        ]);

        return redirect()->to('/allGuesthouses')->with('success', 'Indisponibilité ajoutée');
    }*/
    public function store()
{
    $data = $this->request->getPost();

    // Validation avec le modèle (tu as déjà défini les règles dans ton modèle IndisponibiliteModel)
    if (!$this->indisponibiliteModel->validate($data)) {
        // La validation a échoué, récupérer les erreurs
        $errors = $this->indisponibiliteModel->errors();

        // Rediriger vers le formulaire en gardant les données saisies + erreurs
        return redirect()->back()->withInput()->with('errors', $errors);
    }

    // Vérification complémentaire dateDebut < dateFin
    if (strtotime($data['dateDebut']) > strtotime($data['dateFin'])) {
        return redirect()->back()->withInput()->with('error', 'La date de début doit être antérieure à la date de fin.');
    }

    // Enregistrement dans la base
    $this->indisponibiliteModel->insert($data);

    return redirect()->to('/allGuesthouses')->with('success', 'Indisponibilité ajoutée');
}


    // Supprimer une indisponibilité
    public function delete($idIndisponibilite)
    {
        // Vérifier si l'indisponibilité existe
        $indisponibilite = $this->indisponibiliteModel->find($idIndisponibilite);

        if ($indisponibilite) {
            // Suppression de l'indisponibilité
            $this->indisponibiliteModel->delete($idIndisponibilite);
            return redirect()->to('/allGuesthouses')->with('success', 'Indisponibilité supprimée avec succès.');
        } else {
            return redirect()->to('/allIndisponibilites')->with('error', 'Indisponibilité non trouvée.');
        }
    }
}