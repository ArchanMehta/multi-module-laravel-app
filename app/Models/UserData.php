<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserData extends Model
{
    protected $table = "userdata";
    protected $guarded = [];

    public $timestamps = false;
}
