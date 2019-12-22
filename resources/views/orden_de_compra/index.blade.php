@extends ('layout')

@section('title','Orden de compra')

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('script')
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Orden de compra')

@section('content')

<div class="container" style="margin-top:30px">
    <div class="row">
        <div class="col-md-10 form-group">
            <div>
                <table id="eventsTable" data-toggle="table" data-height="300" data-pagination="true" data-search="true" data-show-refresh="true" data-show-toggle="true" data-show-columns="true" data-classes="table table-bordered table-hover table-md" data-toolbar="#toolbar">
                    <thead>
                        <tr>
                            <th data-sortable="true" data-field="id">Numero</th>
                            <th>Fecha emision</th>
                            <th>Observaciones</th>
                            <th>Condicion</th>
                            <th>Proveedor</th>
                            <th>Ruc</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orden_de_compras as $orden)
                        <tr>
                            <td>{{$orden->numero}}</td>
                            <td>{{ \Carbon\Carbon::parse($orden->fecha_de_emision)->format('d/m/Y')}}</td>
                            <td>{{$orden->observaciones}}</td>
                            <td>{{$orden->condicion}}</td>
                            <td>{{$orden->nombre}}</td>
                            <td>{{$orden->ruc}}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-2 form-group mt-5">
            <div class="col-md-12">
                <a class="btn btn-dark form-group" href="{{ route('orden.create') }}">Agregar</a>
            </div>
            <div class="col-md-12">
                <a id="anular" class="btn btn-dark form-group" onclick="return mensaje_anular()" href="{{ route('orden.destroy', ['numero' => 'empty','proveedor' => 'empty']) }}">Anular</a>
            </div>
            <div class="col-md-12">
                <a id="modificar" style="display: none;" class="btn btn-dark form-group" onclick="return mensaje_modificar()" href="{{ route('orden.edit', 'empty') }}">Modificar</a>
            </div>
        </div>
    </div>
</div>

<script>
var id_sel;
    $('#eventsTable').on('click-row.bs.table', function(e, row) {
        id_sel=row;
         //console.log(row.id);
        var f = document.getElementById("anular").getAttribute("href");
        //console.log(f);
        var pos = f.lastIndexOf("numero/");
        var pos0 = f.lastIndexOf("proveedor/");
       // console.log(pos);
        //console.log(pos0);
        var res = f.slice(0, pos + 7);
        var res0 = f.slice(pos0, pos0+10);
        var link = res.concat(row.id,'/');
        var link0 = res0.concat(row[5]);
        //console.log(link);
        //console.log(link0);
        link3 = link.concat(link0);
       // console.log(link3);
        document.getElementById("anular").setAttribute("href", link3);
    })

    $('#eventsTable').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
    });

    function mensaje() {
        return confirm('Desea eliminar el registro');
    }

    function mensaje_anular() {
        if (id_sel == null) {
            alert("Seleccionar fila primero");
            return false;
        }
    }
    function mensaje_modificar() {
        if (id_sel == null) {
            alert("Seleccionar fila primero");
            return false;
        }
    }
</script>

@endsection