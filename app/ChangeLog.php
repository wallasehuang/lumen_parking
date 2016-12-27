<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $table = 'change_log';

    protected $fillable = array('id', 'parking_lot_id', 'changer_id', 'status', 'quantity');

    public function parking_lot()
    {
        return $this->belongsTo('App\ParkingLot', 'parking_lot_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'changer_id', 'id');
    }

}
