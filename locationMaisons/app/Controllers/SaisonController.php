<?php
namespace App\Controllers;

use App\Models\GuesthouseModel;
use App\Models\SaisonModel;
use CodeIgniter\Controller;

class SaisonController extends Controller
{
    public function genererSaisons2Ans()
    {
        $guesthouseModel = new GuesthouseModel();
        $saisonModel = new SaisonModel();

        $maisons = $guesthouseModel->findAll();

        $anneeDebut = (int)date('Y');
        $anneeFin = $anneeDebut + 1;

        foreach ($maisons as $maison) {
            $prixBase = $maison['prixParNuit'];

            $saisonsAInserer = [];

            for ($annee = $anneeDebut; $annee <= $anneeFin; $annee++) {
                $prixEvolution = ($annee - $anneeDebut) * 5;

                $saisonsAInserer[] = [
                    'annee' => $annee,
                    'typeSaison' => 'Haute',
                    'dateDebut' => "$annee-07-01",
                    'dateFin' => "$annee-08-31",
                    'idMaison' => $maison['idGuesthouse'],
                    'prix' => $prixBase * 2 + $prixEvolution,
                ];
                $saisonsAInserer[] = [
                    'annee' => $annee,
                    'typeSaison' => 'Moyenne',
                    'dateDebut' => "$annee-05-01",
                    'dateFin' => "$annee-06-30",
                    'idMaison' => $maison['idGuesthouse'],
                    'prix' => $prixBase * 1.5 + $prixEvolution,
                ];
                $saisonsAInserer[] = [
                    'annee' => $annee,
                    'typeSaison' => 'Moyenne',
                    'dateDebut' => "$annee-09-01",
                    'dateFin' => "$annee-10-15",
                    'idMaison' => $maison['idGuesthouse'],
                    'prix' => $prixBase * 1.5 + $prixEvolution,
                ];
                $saisonsAInserer[] = [
                    'annee' => $annee,
                    'typeSaison' => 'Basse',
                    'dateDebut' => "$annee-01-01",
                    'dateFin' => "$annee-04-30",
                    'idMaison' => $maison['idGuesthouse'],
                    'prix' => $prixBase + $prixEvolution,
                ];
                $saisonsAInserer[] = [
                    'annee' => $annee,
                    'typeSaison' => 'Basse',
                    'dateDebut' => "$annee-10-16",
                    'dateFin' => "$annee-12-31",
                    'idMaison' => $maison['idGuesthouse'],
                    'prix' => $prixBase + $prixEvolution,
                ];
            }

            $saisonModel->insertBatch($saisonsAInserer);
        }

        return "Saisons générées avec succès pour les maisons existantes !";
    }
}