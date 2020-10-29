<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Fac;
use Illuminate\Http\Request;
use App\Empleado;
use App\Cliente;
use App\Plato;
use App\Pedido;
use Carbon\Carbon;

class FacController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $facturas=Fac::all();
        return response()->json(
        [
        "data:"=> $facturas,
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
            'idEmpleado'=>'required|numeric',
            'idCliente'=>'required|numeric',
            'fct_fch'=>'required|date', //D-M-A
        ]);
        $facturas=Fac::create($request->all());
        return response()->json([
            "message"=> "La factura ha sido creada correctamente",
            "data"=>$facturas,
            "status"=>202
        ], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Fac  $fac
     * @return \Illuminate\Http\Response
     */
    public function show(Fac $fac)
    {
        $now = Carbon::now();
        $dia=$now->format('Y-m-d');//Poner Año-Mes-dia
        //buscamos al cliente al que le pertenece la factura
       $cliente = Cliente::find($fac->idCliente);
       //buscamos al empleado al que le pertenece la factura
       $empleado = Empleado::find($fac->idEmpleado);
        //encontrar a que pedido pertenece la factura
       $detalles=$fac->id;
       $verdetalles= DB::table('detalles')->select('id', 'idPlato')->where('idFac',$detalles)->get();
     //  consultamos el nombre del plato haciendo un  join entre platos (Modelo Plato) y detalles
        $platos_detalle=Plato::join('detalles', 'platos.id', '=', 'detalles.idPlato')->select('platos.id','detalles.dtall_cant', 'detalles.dtall_valor','platos.plt_nom', 'platos.plt_pvp')->where('detalles.idFac', $detalles)->get();
        //consultamos el pedido al que pertenece la factura, activar la clausula where si se quiere que solo se vean los pedidos que perteneces a la fecha actual
        $verpedidos=Pedido::join('detalles', 'pedidos.id', '=', 'detalles.idPedido')->select('pedidos.id', 'pedidos.ped_fch')->where('detalles.idFac', $detalles)->get();
                                                                                                                      //      ->where('pedidos.ped_fch',$dia )->get();

        return response()->json(
            [

            "data"=>$fac,
            "cliente"=>$cliente,
            "empleado"=>$empleado->emp_nom,
            "detalle"=>$verdetalles,
            "detalles_de_platos"=>$platos_detalle,
            "pedidos"=>$verpedidos,
            "status"=>202

            ],202
        );



    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Fac  $fac
     * @return \Illuminate\Http\Response
     */
    public function destroy(Fac $fac)
    {
        $fac->delete();//Se borra completamente el cliente
        return response()->json(
            [
                "message"=>"La factura ha sido borrada",
                "data" => $fac,
                "status"=>202

            ], 202
            );
    }

    public function facsplatos($facplato)
    {
        $fac=Fac::select('id', 'fct_fch')->where('facs.id', '=', $facplato)->get();
        $platos_detalle=Plato::join('detalles', 'platos.id', '=', 'detalles.idPlato')->select('platos.id','detalles.dtall_cant', 'detalles.dtall_valor','platos.plt_nom', 'platos.plt_pvp', 'platos.plt_tipo')
        ->where('detalles.idFac', $facplato)->get();

        $verifac=\json_decode($fac, true);

        if($verifac!=null)
        {
            return  response()->json(
                [
                    "factura" => $fac,
                    "platos_detalle" => $platos_detalle,
                    "status"=>202

                ], 202);
        }
        else
        {
            return  response()->json(
                [
                    "message" => "No existe el número de factura buscado",
                    "status"=>404

                ], 404);

        }

    }
}
