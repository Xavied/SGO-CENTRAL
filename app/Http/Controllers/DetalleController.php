<?php

namespace App\Http\Controllers;

use App\Detalle;
use App\Plato;
use App\Pedido;
use App\Fac;
use App\Estado;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class DetalleController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
        'dtall_cant'=> 'required|numeric',
        'dtall_valor'=> 'required|numeric',
        'idFac'=> 'numeric',
        'idPlato'=> 'required|numeric',
        'idPedido'=> 'required|numeric'

        ]);

        $detalles=Detalle::create($request->all());
        return response()->json([
        "message"=>"El detalle ha sido agregado correctamente",
        "data"=>$detalles,
        "status"=> 202], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function show(Detalle $detalle)
    {
        //vemos el nombre de los platos del detalle
        $nombreplatos = Plato::find($detalle->idPlato);
        //vemos el pedido al que pertenece
        $verpedidos=Pedido::find($detalle->idPedido);
        //vemos a que factura pertenece
        $verfactura = Fac::find($detalle->idFac);
        //vemos el estado del pedido al que pertenece el detalle
        $iddetalle=$detalle->id;
      //vemos el estado en base al pedido encontrado en la variable verpedidos
       $verestado=Estado::find($verpedidos->idEstado);
        return response()->json(
            [
                "data"=>$detalle,
                "platos"=>
                [
                "plato_nombre"=>$nombreplatos->plt_nom,
                "plato_tipo"=>$nombreplatos->plt_tipo,
                "plato_pvp"=>$nombreplatos->plt_pvp
                ],
                "pedidos"=>$verpedidos,
                "estado"=>$verestado->std_desc,
                "factura"=>$verfactura,
                "status"=>202

            ],202);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Detalle  $detalle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Detalle $detalle)
    {
        $detalle->update($request->all()); //a la variable detalle la actualizamos con lo que me llegue de request
        return response()->json([
            "message"=>"El detalle ha sido actualizado",
                "data" => $detalle,
                "status"=>202
        ],202 );
    }

    public function actualizarfac(Request $request, $acfacdetalle)
    {

        $idPedido=Pedido::find($acfacdetalle);
        $idPedido=json_decode($idPedido, true);
        if($idPedido!=null)
        {
            $idDetalle= Detalle::where('idPedido','=',$acfacdetalle)->update(['idFac'=>$request->idFac]);

            return response()->json([
                "message"=>"El detalle ha sido actualizado",
                    "status"=>202
            ],202 );

        }
        else
        {
            return response()->json([
                "message"=>"No existe el pedido: {$acfacdetalle}",
                "status"=>403
            ],403 );

        }
    }

    public function platospedidos($platopedido)
    {
        $idPedido=Pedido::find($platopedido);
        $idPedido=json_decode($idPedido, true);
        if($idPedido!=null)
        {
            $detalleplape=DB::table('detalles')
            ->join('platos', 'platos.id', '=', 'detalles.idPlato')
            ->select('detalles.id', 'detalles.idPlato', 'platos.plt_nom', 'detalles.dtall_cant','platos.plt_pvp' ,'detalles.dtall_valor')
            ->where('detalles.idPedido', '=', $platopedido)->get();
            $verificar=\json_decode($detalleplape, true);

           if($verificar!=null)
            {

            return response()->json([
                "data"=>$detalleplape,
                "status"=>200

            ],200 );


            }
            else
            {
                 return response()->json([
                    "message"=>"No hay nada en este pedido",
                    "status"=>202

                ],202);

            }
 ;

        }
        else
        {
            return response()->json([
                "message"=>"No existe el pedido: {$platopedido}",
                "status"=>404
            ],404);

        }





    }

    public function destroy(Detalle $detalle)
    {
        $detalle->delete();//Se borra completamente el detalle
        return response()->json(
            [
                "message"=>"El detalle ha sido borrado",
                "data" => $detalle,
                "status"=>202

            ], 202
            );
    }





}
