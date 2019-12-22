@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('title','Apertura y cierre editar')

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Apertura y cierre editar')

@section('content')

<form onsubmit="return validateForm()" method="POST" action="{{route('apertura.update',$aperturas[0]->id)}}">
    @csrf
    @method('PUT')
    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="codigo"> Codigo </label>
                    <input type="text" id="codigo" name="codigo" readonly value="{{$aperturas[0]->id}}">
                </div>
                <div class="form-group">
                    <label for="fechaa">Fecha apertura</label>
                    <input type="date" id="fechaa" name="fechaa" required value="{{$aperturas[0]->fecha_apertura}}">
                </div>
                <div class="form-group">
                    <label for="fechac">Fecha cierre</label>
                    <input type="date" id="fechac" name="fechac" required>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="caja">Caja</label>
                    <select id="caja" required name="caja">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($cajas as $caja)
                        @if ($aperturas[0]->caja_id == $caja->id)
                        <option selected value={{ $caja->id }}>{{ $caja->descripcion }}</option>
                        @else
                        <option value={{ $caja->id }}>{{ $caja->descripcion }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="horaa">Hora apertura</label>
                    <input type="time" id="horaa" name="horaa" required value="{{$aperturas[0]->hora_apertura}}">
                </div>
                <div class="form-group">
                    <label for="horae">Hora cierre</label>
                    <input type="time" id="horae" name="horac" required>
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="si"> Saldo inicial </label>
                    <input type="number" id="salini" name="salini" min="0" max="100000000" required value="{{$aperturas[0]->saldo_inicial}}">
                </div>
                <div class="form-group">
                    <label for="sf"> Saldo final </label>
                    <input type="number" id="salfin" name="salfin" value="" min="0" max="100000000" required>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="d-flex flex-wrap justify-content-md-around ">
                        <div class="p-2 mx-auto"><button type="submit" class="btn btn-dark" onclick="return mensaje_grabar()" tabindex="18">GRABAR</button></div>
                        <div class="p-2 mx-auto"><button type="reset" class="btn btn-dark" onclick="remove_all()">CANCELAR</button></div>
                        <div class="p-2 mx-auto"><button type="button" onclick="location.href = '{{ route('estadia.index') }}'" class="btn btn-dark">SALIR</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</form>

<script>
    function showDate(d) {
        var b = d.split('-')
        return b[2] + '/' + b[1] + '/' + b[0];
    }



    function validateForm() {
        var a = document.getElementById("fechaa").value;
        var c = document.getElementById("fechac").value;
        if (a > c) {
            alert("Fecha apertura no puede ser mayor");
            //console.log(x);
            return false;
        }
    }

    function mensaje_grabar() {
        return confirm('Desea grabar el registro');
    }
</script>

@endsection