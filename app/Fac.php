<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fac extends Model
{
    protected $fillable=[
        "id",
        "idEmpleado",
        "idCliente",
        "fct_fch"
     ];
    // protected $hidden= ['id'];
    protected $hidden=["created_at", "updated_at"];


     public function empleado()
     {
         return $this->belongsTo('App\Empleado', 'idEmpleado');
     }

     public function cliente()
     {
         return $this->belongsTo('App\Cliente', 'idCliente');
     }
}
