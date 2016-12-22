<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $table = 'parking_lot';

    protected $fillable = array('id', 'longitude', 'latitude', 'creator_id');

}
