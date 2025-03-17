<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notify extends Model
{
    protected $table = "notifications";
  protected $guarded = [];

  public function task(){
    return $this->belongsTo(Task::class,"task_id");
  }


  public function notifiable()
  {
      return $this->morphTo();  // Polymorphic relationship to the model
  }



}
