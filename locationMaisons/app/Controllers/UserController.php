<?php

namespace App\Controllers;
use App\Models\UserModel;

class UserController extends BaseController
{
    public function createAccount()
    {
        $model = new UserModel();
        $formData = $this->request->getPost();
        $file = $this->request->getFile('photo');
        $result = $model->createUser($formData, $file);

        if (isset($result['error'])) {
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        return view('success');
    }

    public function login()
    {
        if ($this->request->getMethod() == 'post') {
            $model = new UserModel();
            $user = $model->authenticateUser(
                $this->request->getPost('email'),
                $this->request->getPost('motDePasse')
            );

            if ($user) {
                session()->set([
                    'idUtilisateur' => $user['idUtilisateur'],
                    'nom' => $user['nom'],
                    'prenom' => $user['prenom'],
                    'email' => $user['email'],
                    'photo' => $user['photo'],
                    'role' => $user['role'],
                    'is_logged_in' => true
                ]);

                return redirect()->to('personalArea');
            }

            return redirect()->back()->with('error', 'Utilisateur inexistant.');
        }
    }

    public function personalArea()
{
    $userModel = new \App\Models\UserModel();
    $userId = session()->get('idUtilisateur');
    $user = $userModel->find($userId);

    return view('personalArea', ['user' => $user]);
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/');
    }

    public function showUserInfo()
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $user = (new UserModel())->find(session()->get('idUtilisateur'));
        return view('userData', ['user' => $user]);
    }

    public function updateUserInfo()
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        $model = new UserModel();
        $result = $model->updateUserData(
            session()->get('idUtilisateur'),
            $this->request->getPost(),
            $this->request->getFile('photo')
        );

        if (isset($result['error'])) {
            return redirect()->back()->withInput()->with('error', $result['error']);
        }

        return redirect()->to('userData')->with('success', 'Informations mises à jour avec succès.');
    }

    public function deleteUserPhoto()
    {
        if (!session()->has('idUtilisateur')) {
            return redirect()->to('se_connecter')->with('error', 'Veuillez vous connecter.');
        }

        (new UserModel())->deleteUserPhoto(session()->get('idUtilisateur'));
        return redirect()->to('userData')->with('success', 'Photo supprimée avec succès.');
    }

    public function allUsers()
    {
        $users = (new UserModel())->select('idUtilisateur, nom, prenom, role, photo, status')->findAll();
        return view('allUsers', ['users' => $users]);
    }

    public function updateRole()
    {
        $id = $this->request->getPost('idUtilisateur');
        $role = $this->request->getPost('role');

        if ($id == 26 && $role !== 'Administrateur') {
            return redirect()->to(base_url('allUsers'))->with('error', 'Vous ne pouvez pas retirer le rôle de cet utilisateur.');
        }

        (new UserModel())->changeUserRole($id, $role);
        return redirect()->to(base_url('allUsers'))->with('success', 'Rôle mis à jour avec succès.');
    }

    public function anonymiser_utilisateur()
    {
        $id = $this->request->getPost('idUtilisateur');
        (new UserModel())->anonymizeUser($id);
        return redirect()->to(base_url('allUsers'))->with('success', 'Utilisateur anonymisé avec succès.');
    }

    public function bloquer_utilisateur()
    {
        $id = $this->request->getPost('idUtilisateur');
        (new UserModel())->blockUser($id);
        return redirect()->to(base_url('allUsers'))->with('success', 'Utilisateur bloqué avec succès.');
    }

    public function debloquer_utilisateur()
    {
        $id = $this->request->getPost('idUtilisateur');
        (new UserModel())->unblockUser($id);
        return redirect()->to(base_url('allUsers'))->with('success', 'Utilisateur débloqué avec succès.');
    }
}