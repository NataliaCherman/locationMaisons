<?php

namespace App\Controllers;

use App\Models\GuesthouseModel;

class GuesthouseController extends BaseController
{
    // Afficher la vue du catalogue
    public function index() 
    {
        $model = new GuesthouseModel();
        $maisons = $model->findAll();

        return view('/vitrineGuesthouses', ['maisons' => $maisons]);
    }

    // Afficher le formulaire d'ajout d'une maison d'hôte
    public function showguesthouseaddpage() 
    {
        return view('createGuesthouse');
    }

    // Ajouter une maison
    public function addguesthouse() 
    {
        $guesthouseModel = new GuesthouseModel();

        $data = [
            'titre' => $this->request->getPost('titre'),
            'detail' => $this->request->getPost('detail'),
            'village' => $this->request->getPost('village'),
            'pays' => $this->request->getPost('pays'),
            'attractions' => $this->request->getPost('attractions')
        ];

        if (!$guesthouseModel->checkTitleUnique($data['titre'])) {
            return redirect()->to('/createGuesthouse')->withInput()->with('error', 'Le titre de cette maison d\'hôte est déjà utilisé.');
        }

        $validCountries = ['FR', 'IT', 'BE'];
        if (!in_array($data['pays'], $validCountries)) {
            return redirect()->to('/createGuesthouse')->withInput()->with('error', 'Pays invalide. Choisissez parmi FR, IT, BE.');
        }

        $files = $this->request->getFiles();
        $photos = [];
        $uploadDirectory = FCPATH . '/public/uploads/guesthouses/';
        
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if (isset($files['photos'])) {
            foreach ($files['photos'] as $file) {
                if ($file->isValid() && !$file->hasMoved()) {
                    $randomName = uniqid('guesthouse_', true) . '.' . $file->getExtension();
                    $file->move($uploadDirectory, $randomName);
                    $relativePath = '/public/uploads/guesthouses/' . $randomName;
                    $photos[] = $relativePath;
                }
            }
        }

        if (!empty($photos)) {
            $data['photos'] = json_encode($photos);
        }

        if ($guesthouseModel->insert($data)) {
            return redirect()->to('/createGuesthouse')->with('success', 'Maison ajoutée avec succès.');
        } else {
            return redirect()->to('/createGuesthouse')->with('error', 'Échec de l\'ajout de la maison.');
        }
    }
    
    // Afficher toutes les maisons dans le tableau de l'administrateur
    public function allGuesthouses() 
    {
        $guesthouseModel = new GuesthouseModel();
        $guesthouses = $guesthouseModel->findAll();

        return view('AllGuesthouses', ['guesthouses' => $guesthouses]);
    }

    // Datatable pour le tableau affichant toutes les maisons chez l'administrateur
    public function getGuesthousesData() 
    {
        $guesthouseModel = new GuesthouseModel();

        // Paramètres envoyés par DataTables
        $start = $this->request->getVar('start'); // L'index de départ des données
        $length = $this->request->getVar('length'); // Le nombre d'éléments par page
        $search = $this->request->getVar('search')['value']; // Valeur de la recherche

        // Appliquer les filtres si une recherche est effectuée
        $builder = $guesthouseModel->builder();

        if (!empty($search)) {
            // Si une recherche est faite, filtrer par pays
            $builder->orLike('pays', $search);
        }

        // Compter le nombre total de maisons avant filtrage
        $totalRecords = $guesthouseModel->countAllResults(false);

        // Récupérer les maisons avec la pagination
        $guesthouses = $builder->limit($length, $start)->get()->getResultArray();

        // Appliquer les mêmes filtres au comptage des résultats filtrés
        if (!empty($search)) {
            $filteredRecords = $guesthouseModel->builder()->like('pays', $search)->countAllResults(false);
        } else {
            $filteredRecords = $totalRecords;
        }

        // Formater les données pour DataTables
        $data = [];
        foreach ($guesthouses as $guesthouse) {
            $data[] = [
                'idGuesthouse' => isset($guesthouse['idGuesthouse']) ? $guesthouse['idGuesthouse'] : null,
                'titre' => isset($guesthouse['titre']) ? esc($guesthouse['titre']) : null,
                'detail' => isset($guesthouse['detail']) ? esc($guesthouse['detail']) : null,
                'village' => isset($guesthouse['village']) ? esc($guesthouse['village']) : null,
                'pays' => isset($guesthouse['pays']) ? esc($guesthouse['pays']) : null,
                'photos' => !empty($guesthouse['photos']) ? json_decode($guesthouse['photos'])[0] : null,
                'attractions' => isset($guesthouse['attractions']) ? esc($guesthouse['attractions']) : null
            ];        
        }

        // Retourner les données pour DataTables
        return $this->response->setJSON([
            'draw' => $this->request->getVar('draw'),  // Le draw, qui est un numéro d'appel incrémental (utile pour le client)
            'recordsTotal' => $totalRecords,           // Nombre total de maisons
            'recordsFiltered' => $filteredRecords,     // Nombre de maisons après filtrage
            'data' => $data                            // Données des maisons
        ]);
    }

    // Editer une maison
    public function editGuesthouse($idGuesthouse)
    {
        $guesthouseModel = new GuesthouseModel();
        $guesthouse = $guesthouseModel->find($idGuesthouse);

        if ($guesthouse) {
            $photos = !empty($guesthouse['photos']) ? json_decode($guesthouse['photos'], true) : [];

            return view('editGuesthouse', [
                'guesthouse' => $guesthouse,
                'photos' => $photos
            ]);
        } else {
            return redirect()->to('/allGuesthouses')->with('error', 'Maison non trouvée.');
        }
    }

    /*public function updateGuesthouse($id)
    {
        // Vérifier que l'utilisateur est un administrateur
        if (session()->get('role') !== 'Administrateur') {
            return redirect()->to('/allGuesthouses')->with('error', 'Accès refusé.');
        }

        $guesthouseModel = new GuesthouseModel();
        $guesthouse = $guesthouseModel->find($id);

        if (!$guesthouse) {
            return redirect()->to('/allGuesthouses')->with('error', 'Maison introuvable.');
        }

        // Récupérer les données envoyées par le formulaire
        $data = $this->request->getPost([
            'titre', 'detail', 'village', 'pays', 'attractions'
        ]);

        // Validation de l'unicité du titre
        if ($data['titre'] !== $guesthouse['titre'] && !$guesthouseModel->checkTitleUnique($data['titre'])) {
            return redirect()->to('/editGuesthouse/' . $id)->withInput()->with('error', 'Le titre de cette maison d\'hôte est déjà utilisé.');
        }

        // Validation du pays
        $validCountries = ['FR', 'IT', 'BE'];
        if (!in_array($data['pays'], $validCountries)) {
            return redirect()->to('/editGuesthouse/' . $id)->withInput()->with('error', 'Pays invalide. Choisissez parmi FR, IT, BE.');
        }

        // Gestion des photos
        $photos = $this->request->getFiles()['photos'] ?? [];
        $uploadedPaths = [];

        if (!empty($photos) && is_array($photos)) {
            foreach ($photos as $photo) {
                if ($photo->isValid() && !$photo->hasMoved()) {
                    $newName = $photo->getRandomName();
                    $photo->move(FCPATH . '/public/uploads/guesthouses', $newName);
                    $uploadedPaths[] = '/public/uploads/guesthouses/' . $newName;
                }
            }
        }

        if (!empty($uploadedPaths)) {
            // Supprimer les anciennes photos
            if (!empty($guesthouse['photos'])) {
                $oldPhotos = explode(',', $guesthouse['photos']);
                foreach ($oldPhotos as $oldPath) {
                    $oldPath = trim($oldPath);
                    if (file_exists(FCPATH . $oldPath)) {
                        unlink(FCPATH . $oldPath);
                    }
                }
            }

            $data['photos'] = json_encode($uploadedPaths);
        }

        // Mise à jour de la maison dans la base de données
        $guesthouseModel->update($id, $data);

        return redirect()->to('/allGuesthouses')->with('success', 'Maison mise à jour avec succès.');
    }*/
    public function updateGuesthouse($id)
{
    // Vérifier que l'utilisateur est un administrateur
    if (session()->get('role') !== 'Administrateur') {
        return redirect()->to('/allGuesthouses')->with('error', 'Accès refusé.');
    }

    $guesthouseModel = new GuesthouseModel();
    $guesthouse = $guesthouseModel->find($id);

    if (!$guesthouse) {
        return redirect()->to('/allGuesthouses')->with('error', 'Maison introuvable.');
    }

    // Récupérer les données envoyées par le formulaire
    $data = $this->request->getPost([
        'titre', 'detail', 'village', 'pays', 'attractions'
    ]);

    // Validation de l'unicité du titre uniquement si le titre a changé
    if ($data['titre'] !== $guesthouse['titre'] && !$guesthouseModel->checkTitleUnique($data['titre'])) {
        return redirect()->to('/editGuesthouse/' . $id)->withInput()->with('error', 'Le titre de cette maison d\'hôte est déjà utilisé.');
    }

    // Validation du pays
    $validCountries = ['FR', 'IT', 'BE'];
    if (!in_array($data['pays'], $validCountries)) {
        return redirect()->to('/editGuesthouse/' . $id)->withInput()->with('error', 'Pays invalide. Choisissez parmi FR, IT, BE.');
    }

    // Gestion des photos (upload)
    $photos = $this->request->getFiles()['photos'] ?? [];
    $uploadedPaths = [];

    if (!empty($photos) && is_array($photos)) {
        foreach ($photos as $photo) {
            if ($photo->isValid() && !$photo->hasMoved()) {
                $newName = $photo->getRandomName();
                $photo->move(FCPATH . 'public/uploads/guesthouses', $newName);
                $uploadedPaths[] = 'public/uploads/guesthouses/' . $newName;
            }
        }
    }

    // Si de nouvelles photos ont été uploadées, supprimer les anciennes
    if (!empty($uploadedPaths)) {
        if (!empty($guesthouse['photos'])) {
            $oldPhotos = json_decode($guesthouse['photos'], true);
            foreach ($oldPhotos as $oldPath) {
                $oldFullPath = FCPATH . $oldPath;
                if (file_exists($oldFullPath)) {
                    unlink($oldFullPath);
                }
            }
        }

        $data['photos'] = json_encode($uploadedPaths);
    }

    // Désactiver la validation automatique du modèle pour éviter le blocage sur le champ titre
    $guesthouseModel->skipValidation(true)->update($id, $data);

    return redirect()->to('/allGuesthouses')->with('success', 'Maison mise à jour avec succès.');
}


    // Anonymiser les données d'une maison
    public function anonymize($id)
    {
        $model = new \App\Models\GuesthouseModel();
        $guesthouse = $model->find($id);

        if (!$guesthouse) {
            return redirect()->to('/allGuesthouses')->with('error', 'Maison introuvable.');
        }

        $data = [
            'titre'       => 'Anonyme',
            'detail'      => 'Données anonymisées',
            'village'     => '',
            'pays'        => '',
            'attractions' => '',
        ];

        // Supprimer l'image physique si elle existe
        if (!empty($guesthouse['photos']) && is_array(json_decode($guesthouse['photos'], true))) {
            $photos = json_decode($guesthouse['photos'], true);
            foreach ($photos as $photo) {
                if (file_exists(FCPATH . $photo)) {
                    unlink(FCPATH . $photo);
                }
            }
        }

        $model->update($id, $data);

        return redirect()->to('/allGuesthouses')->with('success', 'Maison anonymisée avec succès.');
    }

    // Filtre AJAX pour le catalogue par pays
    public function filter()
    {
        $pays = $this->request->getGet('pays');
        $model = new \App\Models\GuesthouseModel();

        $maisons = !empty($pays)
            ? $model->where('pays', $pays)->findAll()
            : $model->findAll();

        return view('partials/guesthousesList', ['maisons' => $maisons]);
    }

    public function showDetails($id)
{
    $model = new \App\Models\GuesthouseModel();
    $maison = $model->find($id);

    if (!$maison) {
        throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Maison non trouvée');
    }

    return view('detailGuesthouse', ['maison' => $maison]);
}

}