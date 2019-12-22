<?php

namespace App\Http\Controllers;

use App\estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class aperturaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $apertura = DB::table('apertura_cierre')
            ->select(
                'apertura_cierre.*',
                'ca.descripcion as caja'
            )
            ->where('estado', '=', 'A')
            ->leftJoin('caja as ca', 'apertura_cierre.caja_id', '=', 'ca.id')
            ->get();

        // dd($estadia);

        return view('apertura_cierre.index', ['aperturas' => $apertura]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $caja = DB::table('caja')->get();

        return view('apertura_cierre.create', [
            'cajas' => $caja
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dump(request()->all());
         DB::table('apertura_cierre')->insert(
            [
                'caja_id' => request()->caja, 'fecha_apertura' => request()->fechaa,
                'hora_apertura' => request()->horaa, 'saldo_inicial' => request()->salini,
                'usuario_id' => 1, 'estado' => "A"
            ]
        );

        return redirect()->route('apertura.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function show(estadia $estadia)
    {
        dd($estadia);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //dump($id);
        $caja = DB::table('caja')->get();

        $apertura = DB::table('apertura_cierre')
            ->where('id', '=', $id)
            ->get();

        return view('apertura_cierre.update', [
            'cajas' => $caja,            
            'aperturas' => $apertura,            
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
            DB::table('apertura_cierre')->where('id', request()->codigo)
            ->update(
                [
                    'caja_id' => request()->caja, 'fecha_apertura' => request()->fechaa,
                    'hora_apertura' => request()->horaa, 'saldo_inicial' => request()->salini,
                    'usuario_id' => 1, 'estado' => "I", 'fecha_cierre' => request()->fechac,
                    'hora_cierre' => request()->horac, 'saldo_final' => request()->salfin,
                ]
            );

       

        return redirect()->route('apertura.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       
    }

}
