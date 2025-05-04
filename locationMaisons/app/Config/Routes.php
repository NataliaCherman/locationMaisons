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

//Afficher la maison
$routes->get('/detailGuesthouse', 'GuesthouseController::showDetailGuesthouse');

//-------------------------------------------------------RESERVATION--------------------------------------------------
$routes->get('reserveGuesthouse', 'ReservationController::showReservation');
$routes->get('reserveGuesthouse/create', 'ReservationController::create');
$routes->post('reserveGuesthouse/save', 'ReservationController::save');


$routes->get('reserveGuesthouse/recap/(:num)', 'ReservationController::recap/$1');
$routes->get('reserveGuesthouse/recap/(:num)/edit', 'ReservationController::edit/$1');
$routes->post('reserveGuesthouse/update/(:num)', 'ReservationController::update/$1');

$routes->get('reserveGuesthouse/delete/(:num)', 'ReservationController::delete/$1');
$routes->post('reserveGuesthouse/delete/(:num)', 'ReservationController::delete/$1');

//-------------------------------------------------------INDISPONIBILITE--------------------------------------------------
$routes->get('/indisponibilite/create', 'IndisponibiliteController::createIndisponibilite');
$routes->post('indisponibilites/save', 'IndisponibiliteController::save');
$routes->get('indisponibilites/all', 'IndisponibiliteController::allIndisponibilites');
$routes->get('indisponibilites/edit/(:num)', 'IndisponibiliteController::edit/$1');
$routes->post('indisponibilites/update/(:num)', 'IndisponibiliteController::update/$1');
$routes->get('indisponibilites/delete/(:num)', 'IndisponibiliteController::delete/$1');