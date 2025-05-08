<?php
namespace App\Controllers;

use App\Models\ReservationModels;
use App\Models\UserModels;
use App\Models\HouseModels;
use App\Models\IndisponibiliteModels;

class ReservationController extends BaseController
{
    public function makeReservation() {
        return view('reserveGuesthouse');
    }

}
