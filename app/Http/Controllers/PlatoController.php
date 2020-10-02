<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use App\Plato;
use Illuminate\Http\Request;

class PlatoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $platos=Plato::all();
        return response()->json(
        [
        "data:"=> $platos,
        "status"=>200
    ], 200);
    }
    public function store(Request $request)
    {
        $this->validate($request, [
        'plt_pvp'=> 'required|numeric'
        ]);

        $platos=Plato::create($request->all());
        return response()->json([
            "message"=> "Plato agregado",
            "data"=>$platos,
            "status"=>202
        ], 202);
    }


    public function show(Plato $plato)
    {
        return response()->json(
            [
                "data"=>$plato,
                "status"=>202

            ],202
        );


    }

    public function update(Request $request, Plato $plato)
    {
        $plato->update($request->all()); //a la variable plato la actualizamos con lo que me llegue de request
        return response()->json([
            "message"=>"El plato ha sido actualizado",
            "data" => $plato,
            "status"=>202
        ],202 );
    }

    public function tipoplatos($tipoplato)
    {
        $verportipo=DB::table('platos')->select('id','plt_nom','plt_des', 'plt_pvp')->where('plt_tipo','=',$tipoplato)->get();
        $verportipo=\json_decode($verportipo, true);

        if($verportipo!=null)
        {
            return response()->json(
                [

                    "data" => $verportipo,
                    "status"=>202

                ], 202
                );

        }
        else
        {
            return response()->json(
                [

                    "message" => "No hay ese tipo de plato",
                    "status"=>404

                ], 404
                );


        }


    }




}
