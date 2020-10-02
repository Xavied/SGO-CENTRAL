<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable=[
        "id",
        "cli_ci",
        "cli_nom",
        "cli_dir",
        "cli_email",
        "cli_telf"
        ];
       // protected $hidden= ['id'];
       protected $hidden=["created_at", "updated_at"];
}
