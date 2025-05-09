<?php namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'utilisateur';
    protected $primaryKey = 'idUtilisateur';
    protected $returnType = 'array';
    protected $allowedFields = ['nom', 'prenom', 'email', 'motDePasse', 'photo', 'role'];

}
