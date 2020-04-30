<?php

namespace App\Http\Controllers;

use App\estadia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class searcherController extends Controller
{

    public function clientes()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $clientes = DB::table('clientes')
            ->select(
                'clientes.*',
                'pe.nombre',
                'pe.apellido'
            )
            ->leftJoin('persona as pe', function ($join) {
                $join->on('clientes.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('clientes.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

         //dd($clientes);

        return view('buscadores.clientes', ['clientes' => $clientes]);
    }

    public function reservas()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $reservas = DB::table('reservas')
            ->select(
                'reservas.*',
                'op.descripcion as operador',
                'tc.descripcion as tipo_cliente',
                'tr.descripcion as tipo_reserva',
                'pe.nombre',
                'pe.apellido',
                'cl.ruc'
            )
            ->where('estado', '=', 'A')
            ->leftJoin('operador_turistico as op', 'reservas.id_operador', '=', 'op.id')
            ->leftJoin('tipo_cliente as tc', 'reservas.tipo_cliente_id', '=', 'tc.id')
            ->leftJoin('tipo_reserva as tr', 'reservas.tipo_reserva_id', '=', 'tr.id')
            ->leftJoin('clientes as cl', 'reservas.clientes_id', '=', 'cl.id')
            ->leftJoin('persona as pe', function ($join) {
                $join->on('cl.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('cl.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

        // dd($estadia);

        return view('buscadores.reservas', ['reservas' => $reservas]);
    }

    public function tarifas()
    {
        $tarifas = DB::table('tarifas')
            ->select(
                'tarifas.*',
                'tn.descripcion as nombre',
                'te.descripcion as temporada',
                'ha.descripcion as habitacion'
            )
            ->leftJoin('tarifas_nombres as tn', 'tarifas.tarifas_nombres_id', '=', 'tn.id')
            ->leftJoin('temporadas as te', 'tarifas.temporada_id', '=', 'te.id')
            ->leftJoin('habitaciones as ha', 'tarifas.habitacion_id', '=', 'ha.id')
            ->get();

        // dd($estadia);

        return view('buscadores.tarifas', ['tarifas' => $tarifas]);
    }

    public function personas()
    {
        $personas = DB::table('persona')
            ->select(
                'persona.*',
                'td.descripcion as tipo_documento'
            )
            ->leftJoin('tipo_documento as td', 'persona.tipo_documento', '=', 'td.id')
            ->get();

        return view('buscadores.personas', ['personas' => $personas]);
    }

    public function estadias()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $estadia = DB::table('estadia')
            ->select(
                'estadia.*',
                'op.descripcion as operador',
                'tc.descripcion as tipo_cliente',
                'te.descripcion as tipo_estadia',
                'pe.nombre',
                'pe.apellido',
                'cl.ruc'
            )
            ->where('estado', '=', 'A')
            ->leftJoin('operador_turistico as op', 'estadia.id_operador', '=', 'op.id')
            ->leftJoin('tipo_cliente as tc', 'estadia.tipo_cliente_id', '=', 'tc.id')
            ->leftJoin('tipo_estadia as te', 'estadia.Tipo_estadia_id', '=', 'te.id')
            ->leftJoin('clientes as cl', 'estadia.clientes_id', '=', 'cl.id')
            ->leftJoin('persona as pe', function ($join) {
                $join->on('cl.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('cl.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

        // dd($estadia);

        return view('buscadores.estadias', ['estadias' => $estadia]);
    
    }
    public function cuentas_a_cobrar()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        //a=activo i=inactivo
        $cuentas = DB::table('cuentas_a_cobrar')
            ->select(
                'cuentas_a_cobrar.*',
                'pe.nombre',
                'pe.apellido',
                'cl.ruc'
            )
            ->where('cuentas_a_cobrar.estado', '=', 'A')
            ->leftJoin('condicion as co', 'cuentas_a_cobrar.condicion_id', '=', 'co.id')
            ->leftJoin('factura as fa', 'co.factura_numero', '=', 'fa.numero')
            ->leftJoin('clientes as cl', 'fa.clientes_id', '=', 'cl.id')
            ->leftJoin('persona as pe', function ($join) {
                $join->on('cl.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('cl.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

        // dd($estadia);

        return view('buscadores.cuentas_a_cobrar', ['cuentas' => $cuentas]);
    }

    public function apertura_cierre()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        //a=activo i=inactivo
        $apertura = DB::table('apertura_cierre')
            ->select(
                'apertura_cierre.*',
                'ca.descripcion as caja'
            )
            ->where('apertura_cierre.estado', '=', 'A')
            ->leftJoin('caja as ca', 'apertura_cierre.caja_id', '=', 'ca.id')
            ->get();

        // dd($estadia);

        return view('buscadores.apertura_cierre', ['aperturas' => $apertura]);
    }

    public function factura()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        //a=activo i=inactivo
        $factura = DB::table('factura')
            ->select(
                'factura.*',
                'pe.nombre',
                'pe.apellido',
                'cl.ruc'
            )
            ->where('factura.estado', '=', 'A')
            ->leftJoin('clientes as cl', 'factura.clientes_id', '=', 'cl.id')
            ->leftJoin('persona as pe', function ($join) {
                $join->on('cl.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('cl.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

        // dd($estadia);

        return view('buscadores.factura', ['facturas' => $factura]);
    }

    public function articulo()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        //a=activo i=inactivo
        $articulo = DB::table('articulo')
            ->select(
                'articulo.*',
                'un.descripcion as unidad',
                'ca.descripcion as categoria'
            )
            ->leftJoin('unidad as un', 'articulo.unidad_id', '=', 'un.id')
            ->leftJoin('categoria as ca', 'articulo.categoria_id', '=', 'ca.id')
            ->get();

        // dd($estadia);

        return view('buscadores.articulo', ['articulos' => $articulo]);
    }

    public function proveedor()
    {
        $proveedor = DB::table('proveedor')
            ->select(
                'proveedor.*',
                'ci.descripcion as ciudad'
            )
            ->leftJoin('ciudad as ci', 'proveedor.ciudad_id', '=', 'ci.id')
            ->get();

        return view('buscadores.proveedor', ['proveedores' => $proveedor]);
    }

    public function requisicion()
    {
        $requisicion = DB::table('requisicion')
            ->select(
                'requisicion.*',
                'ar.descripcion as area'
            )
            ->leftJoin('area as ar', 'requisicion.area_id', '=', 'ar.id')
            ->get();

        return view('buscadores.requisicion', ['requisiciones' => $requisicion]);
    }
    public function orden()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        //a=activo i=inactivo
        $orden_de_compra = DB::table('orden_de_compra')
            ->select(
                'orden_de_compra.*',
                'pr.ruc',
                'pr.nombre'
            )
            ->where('orden_de_compra.estado', '=', 'A')
            ->leftJoin('proveedor as pr', 'orden_de_compra.proveedor_ruc', '=', 'pr.ruc')
            ->get();

        // dd($estadia);

        return view('buscadores.orden', ['orden_de_compras' => $orden_de_compra]);
    }

    public function huesped()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $huespedes = DB::table('huespedes')
            ->select(
                'huespedes.*',
                'pe.nombre',
                'pe.apellido'
            )
            ->leftJoin('persona as pe', function ($join) {
                $join->on('huespedes.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('huespedes.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

         //dd($clientes);

        return view('buscadores.huespedes', ['huespedes' => $huespedes]);
    }

    public function spa()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $spa = DB::table('spa_sauna')
            ->select(
                'spa_sauna.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.spa', ['spas' => $spa]);
    }
    public function habitacion()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $habitacion = DB::table('habitaciones')
            ->select(
                'habitaciones.*',
                'hn.nombre',
                'th.descripcion as tipo_habitacion',
                'u.descripcion as ubicacion',
                'e.descripcion as estado_habitacion'
                )
            ->leftJoin('habitacion_nombres as hn', 'habitaciones.nombre', '=', 'hn.id')
            ->leftJoin('tipos_habitacion as th', 'habitaciones.id_tipo_hab', '=', 'th.id')
            ->leftJoin('ubicaciones as u', 'habitaciones.id_ubicacion', '=', 'u.id')
            ->leftJoin('habitacion_estado as e', 'habitaciones.estado_id', '=', 'e.id')
            ->get();

         //dd($clientes);

        return view('buscadores.habitacion', ['habitaciones' => $habitacion]);
    }
    public function producto()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $productos = DB::table('productos')
            ->select(
                'productos.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.producto', ['productos' => $productos]);
    }

    public function turismo()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $turismo = DB::table('turismo')
            ->select(
                'turismo.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.turismo', ['turismos' => $turismo]);
    }

    public function cama()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $cama = DB::table('cama')
            ->select(
                'cama.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.cama', ['camas' => $cama]);
    }
    public function empleado()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $empleado = DB::table('empleado')
            ->select(
                'empleado.*',
                'car.descripcion as cargo',
                'pe.nombre',
                'pe.apellido',
                'empleado.persona_nro_documento as documento'
            )
            ->leftJoin('cargo as car', 'empleado.cargo_id', '=', 'car.id')
            ->leftJoin('persona as pe', function ($join) {
                $join->on('empleado.persona_ciudad_id', '=', 'pe.ciudad_id');
                $join->on('empleado.persona_nro_documento', '=', 'pe.nro_documento');
            })
            ->get();

         //dd($clientes);

        return view('buscadores.empleados', ['variables' => $empleado]);
    }
    public function departamento()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $departamento = DB::table('departamento')
            ->select(
                'departamento.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.departamento', ['variables' => $departamento]);
    }
    public function pais()
    {
        //$estadia = estadia::all();
        //return view('estadia.index', ['estadias' => $estadia]);
        $pais = DB::table('pais')
            ->select(
                'pais.*'
            )
            ->get();

         //dd($clientes);

        return view('buscadores.pais', ['variables' => $pais]);
    }
}