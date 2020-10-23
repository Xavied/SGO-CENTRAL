<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Pedido;
use Illuminate\Http\Request;
use App\Mesa;
use App\Estado;
use App\Empleado;
use App\Plato;

class PedidoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//muestra todos los pedidos
    {
        $pedido=Pedido::Select('id', 'ped_fch')->get();
        //$pedido=Pedido::all();
        return response()->json(
        [
        "data"=> $pedido,
        "status"=>200
    ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [

        'idEmpleado'=> 'required|numeric',
        'idMesa'=> 'required|numeric',
        'idEstado'=>'required|numeric',
        'ped_fch'=> 'required|date',//A-M-D

        ]);
        $pedidos=Pedido::create($request->all());
        return response()->json([
        "message"=>"El pedido ha sido creado correctamente",
        "data"=>$pedidos,
        "status"=> 202], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function show(Pedido $pedido)
    {
        //buscamos la mesa donde se encuentra el pedido
        $mesa = Mesa::find($pedido->idMesa);
        //buscamos al empleado al que le pertenece la factura
        $empleado = Empleado::find($pedido->idEmpleado);
        //buscamos el estado del pedido
        $estado=Estado::find($pedido->idEstado);
        //vemos a que detalle pertenece el pedido
        $detalles=$pedido->id;
       $verdetalles= DB::table('detalles')->select('id', 'dtall_cant', 'dtall_valor', 'idFac')->where('idPedido',$detalles)->get();
       //  consultamos el nombre del plato haciendo un  join entre platos (Modelo Plato) y detalles
        $platos_detalle=Plato::join('detalles', 'platos.id', '=', 'detalles.idPlato')->select('platos.id','platos.plt_nom', 'platos.plt_pvp')
        ->where('detalles.idPedido', $detalles)->groupBy('platos.id','platos.plt_nom', 'platos.plt_pvp')->get();
        return response()->json(
            [
                "data"=>$pedido,
                "empleado"=>$empleado,
                "mesa"=>$mesa,
                "estado"=>$estado,
                "detalles"=>$verdetalles,
                "platos"=>$platos_detalle,
                "status"=>202

            ],202
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
   public function update(Request $request, Pedido $pedido)
    {
        $pedido->update($request->all()); //a la variable empresa la actualizamos con lo que me llegue de request
        return response()->json([
            "message"=>"El pedido ha sido actualizado",
            "data" => $pedido,
            "status"=>202
        ],202 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Pedido  $pedido
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pedido $pedido)
    {
        $pedido->delete();
        return response()->json(
            [
                "message"=>"El pedido ha sido borrado",
                "data" => $pedido,
                "status"=>202

            ], 202
            );

    }
}
