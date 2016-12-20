<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChangeLog extends Model
{
    protected $table = 'change_log';

    protected $fillable = array('id', 'parking_lot_id', 'changer_id', 'status', 'quantity');

}
