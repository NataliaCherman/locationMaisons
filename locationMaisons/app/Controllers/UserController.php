<?php

namespace App\Controllers;

use App\Models\UserModel;

class UserController extends BaseController
{
    //Création de compte utilisateur
    public function createAccount() {
        $userModel = new UserModel();

        $password = $this->request->getPost('motDePasse');
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $photo = $this->request->getFile('photo');
        $photoPath = null;

        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move('uploads/', $newName);
            $photoPath = 'uploads/' . $newName;
        }

        $data = [
            'nom' => $this->request->getPost('nom'),
            'prenom' => $this->request->getPost('prenom'),
            'email' => $this->request->getPost('email'),
            'motDePasse' => $hashedPassword,
            'photo' => $photoPath
        ];

        $userModel->save($data);

        return view('success');
    }

    //Connexion à son compte
    public function login() {
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
                return view('personalArea');
            } else {
                return redirect()->back()->with('error', 'Utilisateur inexistant.');
            }
        }
    }
    
    //Déconnexion
    public function logout() {
        $session = session();
        $session->destroy();
        return redirect()->to('/');
    }

    //Afficher données de l'utilisateur
    public function showUserInfo() {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UserModel();
        $user = $userModel->find(session()->get('idUtilisateur'));

        return view('userData', ['user' => $user]);
    }

    //Modifier données de l'utilisateur
    public function updateUserInfo() {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $userModel = new UserModel();
        $userId = session()->get('idUtilisateur');
        $user = $userModel->find($userId);

        $newNom = $this->request->getPost('nom');
        $newPrenom = $this->request->getPost('prenom');
        $newEmail = $this->request->getPost('email');
        $newMotDePasse = $this->request->getPost('motDePasse');

        $data = [
            'nom' => $newNom,
            'prenom' => $newPrenom,
            'email' => $newEmail
        ];

        if (!empty($newMotDePasse)) {
            $data['passwordHash'] = password_hash($newMotDePasse, PASSWORD_BCRYPT);
        }

        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && !$photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move('uploads/', $newName);
            $data['photo'] = 'uploads/' . $newName;

            if (!empty($user['photo']) && file_exists($user['photo'])) {
                unlink($user['photo']);
            }
        }

        $userModel->update($userId, $data);

        return redirect()->to('userData')->with('success', 'Informations mises à jour avec succès');
    }

    /*public function anonymise() {

    }*/

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