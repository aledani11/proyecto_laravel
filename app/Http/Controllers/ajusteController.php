<?php

namespace App\Http\Controllers;

use App\estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ajusteController extends Controller
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
        $inventario = DB::table('inventario')
            ->select(
                'inventario.*',
                'ar.nombre as nombre',
                'ar.descripcion as descripcion',
                'ca.descripcion as categoria'
            )
            ->leftJoin('articulo as ar', 'inventario.articulo_codigo', '=', 'ar.codigo')
            ->leftJoin('categoria as ca', 'ar.categoria_id', '=', 'ca.id')
            ->get();

        // dd($estadia);

        return view('ajuste.index', ['inventarios' => $inventario]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($ajuste)
    {
        //dump($ajuste);

        return view('ajuste.create', [
            'inventario_id' => $ajuste
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
          DB::table('ajuste')->insert(
            [
                'inventario_codigo' => request()->inventario, 'motivo' => request()->motivo,
                'fecha' => request()->fecha
            ]
        );

        DB::table('inventario')
            ->where('codigo', request()->inventario)
            ->update(
                [
                    'stock' => request()->cantidad,
                    'precio' => request()->precio
                ]
            );
       
        return redirect()->route('ajuste.index');
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
        $ciudad = DB::table('ciudad')->get();
        $tipo_documento = DB::table('tipo_documento')->get();

        $personas = DB::table('persona')
            ->where('nro_documento', '=', $id)
            ->get();

        //dd($reservas);
        return view('personas.update', [
            'ciudades' => $ciudad,
            'tipo_documentos' => $tipo_documento,
            'personas' => $personas
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
        //dump($request->all());
        DB::table('persona')
            ->where('nro_documento', request()->numero)
            ->update(
                [
                    'ciudad_id' => request()->ciudad, 'tipo_documento' => request()->tipo_documento,
                    'nombre' => request()->nombre, 'apellido' => request()->apellido,
                    'telefono' => request()->telefono, 'email' => request()->email,
                    'direccion' => request()->direccion, 'fecha_nacimiento' => request()->fecha_nacimiento,
                ]
            );
      

        return redirect()->route('personas.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\estadia  $estadia
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('persona')->where('nro_documento', '=', $id)->delete();

            return redirect()->route('personas.index');
    }

    public function tarifa(Request $request)
    {

        $tarifa = DB::table('tarifas')
            ->select('tn.descripcion', 'tarifas.id', 'tarifas.habitacion_id')
            ->where('tarifas.id', '=', $request->id)
            ->leftJoin('tarifas_nombres as tn', 'tarifas.tarifas_nombres_id', '=', 'tn.id')
            ->get();
        //dd($tarifa);

        //return view('estadia.create', ['tarifas' => $tarifa]);

        return ['tarifas' => $tarifa];
        //return $request;
    }

    public function persona(Request $request)
    {

        $persona = DB::table('persona')
            ->select('nombre', 'apellido')
            ->where([
                ['ciudad_id', '=', $request->id[0]],
                ['nro_documento', '=', $request->id[1]],
            ])->get();
        //dd($tarifa);

        //return view('estadia.create', ['tarifas' => $tarifa]);

        return ['personas' => $persona];
        //return $request;
    }
}
