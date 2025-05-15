<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

//-------------------------------------------------------USER--------------------------------------------------
//Afficher tableau avec tous les utilisateurs + modification role
$routes->get('/allUsers', 'UserController::allUsers');
$routes->post('/update_role', 'UserController::updateRole');

//Créer une compte
$routes->get('/creer_compte', 'Home::createAccount');
$routes->post('/creer_compte', 'UserController::createAccount');

//Se connecter
$routes->get('/login', 'Home::login');
$routes->post('/personalArea', 'UserController::login');

//Se déconnecter
$routes->get('/se_deconnecter', 'UserController::logout');
$routes->get('/personalArea', function () {
    if (!session()->get('is_logged_in')) {
        return redirect()->to('se_connecter');
    }
    return view('personalArea'); 
});

//Afficher toutes les données de l'utilisateur
$routes->get('/userData', 'UserController::showUserInfo');
$routes->post('/userData', 'UserController::updateUserInfo');

$routes->get('deleteUserPhoto', 'UserController::deleteUserPhoto');

//Anonymiser l'utilisateur
$routes->post('/allUsers', 'UserController::anonymiser_utilisateur');

//Bloquer l'utilisateur
$routes->post('bloquer_utilisateur', 'UserController::bloquer_utilisateur');

//Débloquer l'utilisateur
$routes->post('debloquer_utilisateur', 'UserController::debloquer_utilisateur');


//-------------------------------------------------------GUESTHOUSE--------------------------------------------------
//Créer une maison
$routes->get('/createGuesthouse', 'GuesthouseController::showguesthouseaddpage');
$routes->post('/createGuesthouse', 'GuesthouseController::addguesthouse');

//Page affichant toutes les maisons accessible à tous les utilisateurs (les non inscrits aussi)
$routes->get('/vitrineGuesthouses', 'GuesthouseController::index');

//Tableau des maisons disponibles sur la plateforme + modifiable par l'administrateur
$routes->get('/allGuesthouses', 'GuesthouseController::allGuesthouses');
$routes->post('/getGuesthousesData', 'GuesthouseController::getGuesthousesData'); // Récupération des données via AJAX

//Route pour éditer une maison
$routes->get('/allGuesthouses/edit/(:num)', 'GuesthouseController::editGuesthouse/$1');

//Route pour mettre à jour une maison
$routes->post('/allGuesthouses/update/(:num)', 'GuesthouseController::updateGuesthouse/$1');
//Route anonymiser
$routes->get('/allGuesthouses/anonymize/(:num)', 'GuesthouseController::anonymize/$1');

//Afficher détails d'une maison
$routes->get('guesthouse/showDetails/(:num)', 'GuesthouseController::showDetails/$1');

//Filtre AJAX pour le catalogue par pays
$routes->get('guesthouses/filter', 'GuesthouseController::filter');

//-------------------------------------------------------RESERVATION--------------------------------------------------
// ADMIN
$routes->get('reservation/marquerPaiementEffectue/(:num)', 'ReservationController::marquerPaiementEffectue/$1');
$routes->get('reservation/verifierPaiement', 'ReservationController::verifierPaiementNonEffectue');
$routes->get('reservation/maison/(:num)/admin', 'ReservationController::adminMaisonReservations/$1');

// UTILISATEUR
$routes->get('reservation/signalerPaiement/(:num)', 'ReservationController::signalerPaiement/$1');
$routes->get('reservation/maison/(:num)', 'ReservationController::showReservationForm/$1');
$routes->post('reservation/create', 'ReservationController::createReservation');


$routes->post('reservation/calculerPrix', 'ReservationController::calculerPrixAjax');

//------------------------------------------------------SAISONS--------------------------------------------------------
$routes->get('saison/generer', 'SaisonController::genererSaisons2Ans');
//a mettre dans le navigateur : http://localhost/locationMaisons/saison/generer (réponse : Saisons générées avec succès pour les maisons existantes !)


//-------------------------------------------------------INDISPONIBILITE--------------------------------------------------
// Affiche l'indisponibilité de la maison
$routes->get('indisponibilite/(:num)', 'IndisponibiliteController::index/$1');

// Affiche le formulaire de création d'indisponibilité
$routes->get('indisponibilite/(:num)/create', 'IndisponibiliteController::create/$1');

// Gère la soumission du formulaire
$routes->post('indisponibilite/store', 'IndisponibiliteController::store');

// Supprimer
$routes->post('indisponibilite/delete/(:num)', 'IndisponibiliteController::delete/$1');



