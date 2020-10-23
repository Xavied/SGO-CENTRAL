<?php

namespace App\Http\Controllers;

use App\Mesa;
use App\Detalle;
use App\Pedido;
use App\Fac;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MesaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $mesa=Mesa::all();
        return response()->json(
        [
        "data"=> $mesa,
        "status"=>200
    ], 200);
    }

    public function store(Request $request)
    {

        $mesas=Mesa::create($request->all());
        return response()->json([
            "message"=> "Mesa agregada",
            "data"=>$mesas,
            "status"=>202
        ], 202);
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Mesa  $mesa
     * @return \Illuminate\Http\Response
     */
    public function show(Mesa $mesa)
    {
        //obtenemos la fecha del día
        $now = Carbon::now();
        $dia=$now->format('Y-m-d');//Poner Año-Mes-dia
        //vemos que pedidos tiene la mesa
        $pedido=$mesa->id;
        $verpedidos= DB::table('pedidos')->select('id', 'idEstado', 'idEmpleado')->where('idMesa','=', $pedido)->where( 'ped_fch','=', $dia)
                                                                                          ->where('ped_terminado', '=', false)->get();
        //Transformamos al pedido en un arreglo para verificar si está o no vacio
        $comprobarpedidos=\json_decode($verpedidos, true);
        if($comprobarpedidos!=null)
        {
            //vemos el detalle del pedido de la mesa a la que pertence
            $detalles=$mesa->id;
            $verdetalles=Detalle::join('pedidos', 'detalles.idPedido', '=', 'pedidos.id')
            ->select('detalles.dtall_valor', 'detalles.idPlato', 'detalles.dtall_cant', 'detalles.idFac')->where('pedidos.idMesa', $detalles)->where( 'pedidos.ped_fch','=', $dia)
             ->where('pedidos.ped_terminado', '=', false)->get();

            //vemos la factura que tiene el mesa y el cliente de esa factura
            $facturas=DB::table('pedidos')
            ->join('detalles', 'pedidos.id', '=', 'detalles.idPedido')
            ->join('facs', 'detalles.idFac', '=', 'facs.id')
            ->join('clientes', 'clientes.id', '=', 'facs.idCliente')
            ->select('pedidos.id','detalles.idFac', 'clientes.cli_ci', 'clientes.cli_nom', 'clientes.cli_dir', 'clientes.cli_telf' )
            ->where('pedidos.idMesa', '=', $detalles)
            ->where( 'pedidos.ped_fch','=', $dia)
            ->where('pedidos.ped_terminado', '=', false)->groupBy('pedidos.id','idFac', 'cli_ci', 'cli_nom', 'cli_dir', 'cli_telf')->get();
            //$facturas=$facturas->groupBy('idFac');
            //vemos los platos que tiene esa mesa
            $platos=DB::table('pedidos')
            ->join('detalles', 'pedidos.id', '=', 'detalles.idPedido')
            ->join('platos', 'detalles.idPlato', '=', 'platos.id')
            ->select('plt_nom')
            ->where('pedidos.idMesa', '=', $detalles)
            ->where( 'pedidos.ped_fch','=', $dia)
            ->where('pedidos.ped_terminado', '=', false)->groupBy('plt_nom')->get();



                return response()->json(
                    [
                        "data"=>$mesa,
                        "pedidos"=>$verpedidos,
                        "detalles"=>$verdetalles,
                        "clientes"=>$facturas,//el id que aparece es de la factura, no del cliente
                        "platos"=>$platos,
                        "status"=>202

                    ],202
                );

        }
        else
        {
            return response()->json(
                [
                    "message"=>"No existen pedidos en esta mesa",
                    "status"=>200
                ],200
            );
        }

    }
}
