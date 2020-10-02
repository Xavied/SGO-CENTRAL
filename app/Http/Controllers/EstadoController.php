<?php

namespace App\Http\Controllers;

use App\Estado;
use Illuminate\Http\Request;

class EstadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estados=Estado::all();
        return response()->json(
        [
        "data:"=> $estados,
        "status"=>200
    ], 200);
    }
    public function store(Request $request)
    {

        $estados=Estado::create($request->all());
        return response()->json([
            "message"=> "Estado agregado",
            "data"=>$estados,
            "status"=>202
        ], 202);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Estado  $estado
     * @return \Illuminate\Http\Response
     */

    public function show(Estado $estado)
    {
        return response()->json(
            [
                "estate"=>$estado,
                "status"=>202

            ],202
        );
    }

}
