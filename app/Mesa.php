<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mesa extends Model
{
    protected $fillable=['mes_descr'];
   // protected $hidden=['id'];
   protected $hidden=["created_at", "updated_at"];
}
