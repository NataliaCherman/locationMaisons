<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    // Création de compte utilisateur
    public function createAccount() 
        {
        $userModel = new UserModel();

        // Récupération du mot de passe
        $password = $this->request->getPost('motDePasse');
        $confirmPassword = $this->request->getPost('confirmMotDePasse'); // Récupération du mot de passe de confirmation

        // Vérification que les mots de passe correspondent
        if ($password !== $confirmPassword) {
            return redirect()->back()->withInput()->with('error', 'Les mots de passe ne correspondent pas.');
        }

        // Vérification de la force du mot de passe
        if (!$this->isStrongPassword($password)) {
            return redirect()->back()->withInput()->with('error', 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
        }

        // Hachage du mot de passe
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $file = $this->request->getFile('photo');

        $uploadDirectory = FCPATH . 'uploads/users/';

        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true);
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $randomName = $file->getRandomName();

            $file->move($uploadDirectory, $randomName);

            $relativePath = 'uploads/users/' . $randomName;
        } else {
            $relativePath = '';
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'motDePasse' => $hashedPassword,
            'photo' => $relativePath
        ];

        $userModel->save($data);

        return view('success');
    }


    //Connexion à son compte
    public function login() 
    {
        $session = session();
        helper(['form']);

        if ($this->request->getMethod() == 'post') {
            $userModel = new UserModel();
            $email = $this->request->getPost('email');
            $motDePasse = $this->request->getPost('motDePasse');

            $user = $userModel->where('email', $email)->first();

            if ($user && password_verify($motDePasse, $user['motDePasse'])) {
                $session->set([
                    'idUtilisateur' => $user['idUtilisateur'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'motDePasse' => $user['motDePasse'],
                    'photo' => $user['photo'],
                    'role' => $user['role'],
                    'is_logged_in' => true
                ]);
                return redirect()->to('personalArea');
            } else {
                return redirect()->back()->with('error', 'Utilisateur inexistant.');
            }
        }
    }

    
    // Déconnexion
    public function logout() 
    {
        $session = session();
        
        // Détruire la session
        $session->destroy();

        return redirect()->to('/');
    }


    // Afficher données de l'utilisateur pour modification du profil
    public function showUserInfo() 
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('idUtilisateur'));

        return view('userData', ['user' => $user]);
    }


    // Modifier les données d'un utilisateur
    public function updateUserInfo() 
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UserModel();
        $userId = session()->get('idUtilisateur');
        $user = $userModel->find($userId);

        $newNom = $this->request->getPost('nom');
        $newPrenom = $this->request->getPost('prenom');
        $newEmail = $this->request->getPost('email');
        $newMotDePasse = trim($this->request->getPost('motDePasse'));

        $data = [
            'nom'    => $newNom,
            'prenom' => $newPrenom,
            'email'  => $newEmail,
        ];

        if (!empty($newMotDePasse)) {
            if (!$this->isStrongPassword($newMotDePasse)) {
                return redirect()->back()->withInput()->with('error', 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.');
            }

            $data['motDePasse'] = password_hash($newMotDePasse, PASSWORD_BCRYPT);
        }

        // Gérer la photo de profil
        $file = $this->request->getFile('photo');
        $uploadDirectory = FCPATH . 'uploads/users/';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $randomName = $file->getRandomName();
            $file->move($uploadDirectory, $randomName);
            $relativePath = 'uploads/users/' . $randomName;
            $data['photo'] = $relativePath;

            // Supprimer l'ancienne photo si elle existe
            if (!empty($user['photo']) && file_exists(FCPATH . $user['photo'])) {
                unlink(FCPATH . $user['photo']);
            }
        }

        // Mettre à jour les données dans la base de données
        if (!$userModel->update($userId, $data)) {
            return redirect()->back()->withInput()->with('error', 'Erreur lors de la mise à jour des informations : ' . implode(', ', $userModel->errors()));
        }

        //log_message('debug', 'Mise à jour réussie pour l\'utilisateur avec l\'ID ' . $userId);

        return redirect()->to('userData')->with('success', 'Informations mises à jour avec succès.');
    }


    private function isStrongPassword($password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
    }


    // Suppression de la photo de l'utilisateur
    public function deleteUserPhoto() 
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UserModel();
        $userId = session()->get('idUtilisateur');
        $user = $userModel->find($userId);

        if (!empty($user['photo']) && file_exists(FCPATH . $user['photo'])) {
            unlink(FCPATH . $user['photo']);
            $data = ['photo' => null];
            $userModel->update($userId, $data);
        }

        return redirect()->to('userData')->with('success', 'Photo supprimée avec succès.');
    }



    //Afficher tous les utilisateurs inscrits sur la plateforme
    public function allUsers() {
        $userModel = new UserModel();
        $users = $userModel->select('idUtilisateur, nom, prenom, role')->findAll();
    
        return view('AllUsers', ['users' => $users]);
    }
        
    //Mise à jour du rôle
    public function updateRole() {
        if (!$this->request->getPost()) {
            return redirect()->back()->with('error', 'Requête invalide.');
        }
    
        $userModel = new UserModel();
        $idUtilisateur = $this->request->getPost('idUtilisateur');
        $newRole = $this->request->getPost('role');

        // L'ID de l'utilisateur à protéger
        $protectedUserId = 26;

        // Vérifie si l'utilisateur protégé est celui qu'on essaie de modifier
        if ($idUtilisateur == $protectedUserId && $newRole !== 'Administrateur') {
            return redirect()->back()->with('error', 'Vous ne pouvez pas retirer le rôle d\'Administrateur à cet utilisateur.');
        }
    
        $user = $userModel->find($idUtilisateur);
    
        $userModel->update($idUtilisateur, ['role' => $newRole]);
    
        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }
        
}