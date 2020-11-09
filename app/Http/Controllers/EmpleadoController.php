<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Empleado;
use Illuminate\Http\Request;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados=Empleado::all();
        return response()->json(
        [
        "data:"=> $empleados,
        "status"=>200
    ], 200);
    }
    public function store(Request $request)
    {

        $empleados=Empleado::create($request->all());
        return response()->json([
            "message"=> "Empleado agregado",
            "data"=>$empleados,
            "status"=>202
        ], 202);
    }



    /**
     * Display the specified resource.
     *
     * @param  \App\Empleado  $empleado
     * @return \Illuminate\Http\Response
     */
    public function show(Empleado $empleado)
    {
        $now = Carbon::now();
        $dia=$now->format('Y-m-d');//Poner Año-Mes-dia

        $factura=$empleado->id;
        $pedido=$empleado->id;
        //datos de las facturas que tiene el empleado
        $verfacturas= DB::table('facs')->select('id')->where('idEmpleado',$factura)->where('facs.fct_fch',$dia )->get();
        //datos de los pedidos que tiene el empleado pero solo de la fecha actual
        //nos evitamos que un empleado pueda ver todos! sus pedidos de fechas anteriores
        $verpedidos= DB::table('pedidos')->select('id','idMesa', 'idEstado', 'ped_terminado')->where('idEmpleado','=', $pedido)->where( 'ped_fch','=', $dia)->where('ped_terminado', '=', false)->get();

        return response()->json(
            [
                "data"=>$empleado,
                "fac_empleado"=>$verfacturas,
                "emple_pedido"=>$verpedidos,
                //"fecha"=>$dia, //Nos muestra la fecha actual.
                "status"=>202

            ],202);
    }
    //método para actualizar
    public function update(Request $request, Empleado $empleado)
    {
        $empleado->update($request->all()); //a la variable empleado la actualizamos con lo que me llegue de request
        return response()->json([
            "message"=>"El empleado ha sido actualizado",
            "data" => $empleado,
            "status"=>202
        ],202 );
    }
    //método para borrar
    public function destroy( Empleado $empleado )
    {
        $empleado->delete();//Se borra completamente el empleado
        return response()->json(
            [
                "message"=>"El empleado ha sido borrado",
                "data" => $empleado,
                "status"=>202

            ], 202
            );
    }



}
