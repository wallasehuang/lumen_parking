<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = array('id', 'account', 'name', 'password', 'remember_token');
    protected $hidden   = array('password', 'remember_token');

    public function parking_lot()
    {
        return $this->hasMany('App\ParkingLot', 'creator_id', 'id');
    }

    public function change_log()
    {
        return $this->hasMany('App\ChangeLog', 'changer_id', 'id');
    }

}
