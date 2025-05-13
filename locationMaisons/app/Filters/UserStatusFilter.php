<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\UserModel;

class UserStatusFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();

        if ($session->has('idUtilisateur')) {
            $userModel = new UserModel();
            $user = $userModel->find($session->get('idUtilisateur'));

            if ($user && $user['status'] === 'bloqué') {
                $session->destroy(); // Déconnecter l'utilisateur
                return redirect()->to('se_connecter')->with('error', 'Votre compte est bloqué.');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null){}
}
