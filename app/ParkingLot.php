<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ParkingLot extends Model
{
    protected $table = 'parking_lot';

    protected $fillable = array('id', 'longitude', 'latitude', 'creator_id');

    public function user()
    {
        return $this->belongsTo('App\User', 'creator_id', 'id');
    }

    public function info()
    {
        return $this->hasMany('App\ChangeLog', 'parking_lot_id', 'id');
    }

}
