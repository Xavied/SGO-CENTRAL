<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Plato extends Model
{
    protected $fillable=[
        'plt_nom',
        'plt_des',
        'plt_tipo',
        'plt_pvp',
        'plt_iva'

    ];
    //protected $hidden= ['id'];
    protected $hidden=["created_at", "updated_at"];

}
