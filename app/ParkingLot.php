<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $table = 'parking_lot';

    protected $fillable = array('id', 'logitude', 'latitude', 'quantity', 'creator_id', 'change_log_id');

}
