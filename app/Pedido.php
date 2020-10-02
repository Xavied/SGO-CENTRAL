<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $fillable=[
        "id",
        "idEmpleado",
        "idMesa",
        "idEstado",
        "ped_fch",
        "ped_terminado"
     ];
     //protected $hidden= ['id'];
     protected $hidden=["created_at", "updated_at"];

     public function Empleado()
     {
         return $this->belongsTo('App\Empleado', 'idEmpleado');
     }

     public function Mesa()
     {
         return $this->belongsTo('App\Mesa', 'idMesa');
     }

     public function Estado()
     {
         return $this->belongsTo('App\Estado', 'idEstado');
     }
}
