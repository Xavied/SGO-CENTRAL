<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $fillable=[
        "id",
        "dtall_cant",
        "dtall_valor",
        "idFac",
        "idPlato",
        "idPedido"
        ];
       // protected $hidden= ['id'];
       protected $hidden=["created_at", "updated_at"];
        public function Fac()
        {
            return $this->belongsTo('App\Fac', 'idFac');
        }
        public function Plato()
        {
            return $this->belongsTo('App\Plato', 'idPlato');
        }
        public function Pedido()
        {
            return $this->belongsTo('App\Pedido', 'idPedido');
        }
}
