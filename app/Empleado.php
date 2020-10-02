<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    protected $fillable=[
        "id",
        "emp_ci",
        "emp_nom",
        "emp_dir",
        "emp_telf",
        "emp_crg"
    ];
  //  protected $hidden= ['id'];
  protected $hidden=["created_at", "updated_at"];

  public function user()
  {
      return $this->hasOne('App\User');
  }
}
