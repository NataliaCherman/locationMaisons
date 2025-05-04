<?php namespace App\Models;
use CodeIgniter\Model;

class GuesthouseModel extends Model
{
    protected $table = 'Guesthouses';
    protected $primaryKey = 'idGuesthouse';
    protected $returnType = 'array';
    protected $allowedFields = ['titre', 'detail', 'village', 'pays', 'photos', 'attractions'];
}