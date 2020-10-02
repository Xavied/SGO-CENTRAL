<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable=[
        "std_desc"
    ];
    //protected $hidden= ['id'];
    protected $hidden=["id","created_at", "updated_at"];
}
