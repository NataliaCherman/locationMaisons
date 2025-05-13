<?php

namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'idUtilisateur';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'motDePasse', 'photo', 'role', 'status'];

    public function isStrongPassword($password): bool
    {
        return preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/', $password);
    }

    // CREATION UTILISATEUR
    public function createUser(array $formData, $file = null): array
    {
        if ($formData['motDePasse'] !== $formData['confirmMotDePasse']) {
            return ['error' => 'Les mots de passe ne correspondent pas.'];
        }

        if (!$this->isStrongPassword($formData['motDePasse'])) {
            return ['error' => 'Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'];
        }

        $hashedPassword = password_hash($formData['motDePasse'], PASSWORD_BCRYPT);
        $relativePath = '';

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDirectory = FCPATH . 'uploads/users/';

            //Vérification de si le répertoire existe, sinon création du répertoire
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            // Nom aléatoire généré pour le fichier
            $randomName = $file->getRandomName();

            // Fichier déplacé dans le répertoire
            $file->move($uploadDirectory, $randomName);
            $relativePath = 'uploads/users/' . $randomName;
        }

        $data = [
            'nom' => $formData['nom'],
            'prenom' => $formData['prenom'],
            'email' => $formData['email'],
            'motDePasse' => $hashedPassword,
            'photo' => $relativePath
        ];

        if ($this->save($data)) {
            return ['success' => true];
        }

        return ['error' => 'Une erreur est survenue lors de la création du compte.'];
    }

    public function authenticateUser($email, $motDePasse)
    {
        $user = $this->where('email', $email)->first();

        if ($user && password_verify($motDePasse, $user['motDePasse'])) {
            return $user;
        }

        return null;
    }

    public function updateUserData($userId, array $formData, $file = null): array
    {
        $user = $this->find($userId);

        $data = [
            'nom' => $formData['nom'],
            'prenom' => $formData['prenom'],
            'email' => $formData['email']
        ];

        if (!empty(trim($formData['motDePasse']))) {
            if (!$this->isStrongPassword($formData['motDePasse'])) {
                return ['error' => 'Mot de passe non conforme. Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.'];
            }

            $data['motDePasse'] = password_hash($formData['motDePasse'], PASSWORD_BCRYPT);
        }

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $uploadDirectory = FCPATH . 'uploads/users/';

             // Créer le dossier 'uploads/users/' s'il n'existe pas
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $randomName = $file->getRandomName();
            $file->move($uploadDirectory, $randomName);

            $data['photo'] = 'uploads/users/' . $randomName;

            if (!empty($user['photo']) && file_exists(FCPATH . $user['photo'])) {
                unlink(FCPATH . $user['photo']);
            }
        }

        if ($this->update($userId, $data)) {
            return ['success' => true];
        }
        return ['error' => 'Erreur de mise à jour.'];
    }

    public function deleteUserPhoto($userId)
    {
        $user = $this->find($userId);

        if ($user && !empty($user['photo']) && file_exists(FCPATH . $user['photo'])) {
            unlink(FCPATH . $user['photo']);
        }

        return $this->update($userId, ['photo' => null]);
    }

    public function changeUserRole($id, $role)
    {
        return $this->update($id, ['role' => $role]);
    }

    public function anonymizeUser($id)
    {
        $user = $this->find($id);

        if ($user && !empty($user['photo']) && $user['photo'] !== 'uploads/users/defaut.png') {
            $oldPhotoPath = FCPATH . $user['photo'];
            if (file_exists($oldPhotoPath)) {
                unlink($oldPhotoPath);
            }
        }

        return $this->update($id, [
            'nom' => 'Anonyme',
            'prenom' => 'Anonyme',
            'photo' => null
        ]);
    }

    // BLOCAGE et DEBLOCAGE UTILISATEUR
    public function blockUser($id)
    {
        return $this->update($id, ['status' => 'bloqué']);
    }

    public function unblockUser($id)
    {
        return $this->update($id, ['status' => 'actif']);
    }
}