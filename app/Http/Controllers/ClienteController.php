<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Cliente;
use App\Detalle;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()//muestra todos los clientes
    {
        $cliente=Cliente::all();
        return response()->json(
        [
        "data:"=> $cliente,
        "status"=>200
    ], 200);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)//guarda un cliente
    {
        $this->validate($request, [
            'cli_ci' => 'required|numeric',
            'cli_nom' => 'required',
            'cli_dir' => 'required',
            'cli_email' => 'required',
            'cli_telf' => 'required|numeric',

        ]);
        $cliente=Cliente::create($request->all());
        return response()->json([
            "message"=> "El cliente ha sido agregado correctamente",
            "data"=>$cliente,
            "status"=>202
        ], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function show(Cliente $cliente)//muestra un cliente por id
    {
        $factura=$cliente->id;//obtenemos el id ingresado en el get de la variable cliente
        //vemos todas las facturas que tiene el cliente
        $verfacturas= DB::table('facs')->select('id', 'fct_fch')->where('idCliente',$factura)->get();
        //vemos los detalles que pertenecen al cliente
        $detalles=$cliente->id;
        $verdetalles=Detalle::join('facs', 'detalles.idFac', '=', 'facs.id')->select('detalles.id','detalles.dtall_valor', 'detalles.idPlato', 'detalles.dtall_cant')
        ->where('facs.idCliente', $detalles)->get();

        return response()->json(
            [
                "data"=>$cliente,
                "faccli"=>$verfacturas,
                "detacli"=>$verdetalles,
                "status"=>202

            ],202
        );
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->all()); //a la variable cliente la actualizamos con lo que me llegue de request
        return response()->json([
            "message"=>"El cliente ha sido actualizado",
            "data" => $cliente,
            "status"=>202
        ],202 );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cliente  $cliente
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();//Se borra completamente el cliente
        return response()->json(
            [
                "message"=>"El cliente ha sido borrado",
                "data" => $cliente,
                "status"=>202

            ], 202
            );
    }

    public function buscarcedula(Request $request)
    {
        $cedula=$request->cli_ci;


        $buscarcedula=DB::table('clientes')->select('id','cli_ci', 'cli_nom', 'cli_dir', 'cli_dir', 'cli_email', 'cli_telf')->where('cli_ci','=',$cedula)->get();

        $buscarcedula=\json_decode($buscarcedula, true);

        if($buscarcedula!=null)
        {
            return response()->json(
                [

                    "data" => $buscarcedula,
                    "status"=>202

                ], 202
                );

        }
        else
        {
            return response()->json(
                [

                    "message" => "No hay un cliente con esa cédula",
                    "status"=>404

                ], 404
                );


        }

    }
    //Podemos buscar a un cliente a través de su cédula
    public function verporcedula($cedulacliente)
    {
        $buscarcedula=DB::table('clientes')->select('id','cli_ci', 'cli_nom', 'cli_dir', 'cli_dir', 'cli_email', 'cli_telf')
        ->where('cli_ci','=',$cedulacliente)->get();

        //Activar si se requiere ver la factura y el detalle de esas facturas. Activar los comentarios en el response de abajo(el único que está comentado)
       /* $verfacturas=DB::table('facs')
         ->join('clientes', 'clientes.id', '=', 'facs.idCliente')
         ->select('facs.id', 'facs.fct_fch' )
         ->where('clientes.cli_ci', '=', $cedulacliente)->get();

         $verdetalles=DB::table('clientes')
         ->join('facs', 'clientes.id', '=', 'facs.idCliente')
         ->join('detalles', 'facs.id', '=', 'detalles.idFac')
         ->join('platos', 'platos.id', '=', 'detalles.idPlato')
         ->select('facs.id','detalles.dtall_cant', 'detalles.dtall_valor', 'platos.plt_nom', 'platos.plt_pvp')
         ->where('clientes.cli_ci', '=', $cedulacliente)->get();*/
       $buscarcedula=\json_decode($buscarcedula, true);

        if($buscarcedula!=null)
        {
            return response()->json(
                [

                    "data" => $buscarcedula,
                   /* "facturas"=>$verfacturas,
                    "detalles"=>$verdetalles,*/
                    "status"=>202

                ], 202
                );

        }
        else
        {
            return response()->json(
                [

                    "message" => "No hay un cliente con esa cédula",
                    "status"=>404

                ], 404
                );


        }
    }

}
