<?php

namespace App\Http\Controllers;
use App\ParkingLot;

class ParkingLotController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }


    public function index(){
        return ParkingLot::all();
    }
}
