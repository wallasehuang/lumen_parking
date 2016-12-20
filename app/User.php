<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'users';

    protected $fillable = array('id', 'account', 'name', 'password', 'remember_token');
    protected $hidden   = array('password', 'remember_token');

}
