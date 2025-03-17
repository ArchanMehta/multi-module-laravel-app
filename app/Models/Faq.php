<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $table = "userfaq";
    protected $guarded = [];

    public $timestamps = false;
}
