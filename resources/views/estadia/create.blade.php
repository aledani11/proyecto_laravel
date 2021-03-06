@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('title','Estadía agregar')

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Estadía agregar')

@section('content')

<form onsubmit="return validateForm()" method="POST" action="{{route('estadia.store')}}">
    @csrf

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id"> Codigo </label>
                    <input type="text" id="id" name="codigo" readonly>
                </div>
                <div class="form-group">
                    <label for="operador">Operador</label>
                    <select id="operador" name="operador" required tabindex="2">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($operadores as $operador)
                        <option value={{ $operador->id }}>{{ $operador->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="tipoe">Tipo estadia</label>
                    <select id="tipoe" name="tipo_estadia" required tabindex="4">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($tipo_estadias as $tipo_estadia)
                        <option value={{ $tipo_estadia->id }}>{{ $tipo_estadia->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" required value="{{\Carbon\Carbon::now(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                </div>
                <div class="form-group">
                    <label for="tipoc">Tipo cliente</label>
                    <select id="tipoc" name="tipo_cliente" required tabindex="3">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($tipo_clientes as $tipo_cliente)
                        <option value={{ $tipo_cliente->id }}>{{ $tipo_cliente->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="reserva">Reserva</label>
                    <input type="text" id="reserva" name="reserva" class="readonly" autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('reserva')" tabindex="5">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="comentarios">Comentarios</label>
                    <textarea autofocus id="comentarios" cols="30" rows="4" name="comentarios" maxlength="100" required tabindex="1"></textarea>
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente</label>
                    <input type="text" id="cliente" name="cliente" required class="readonly" autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('cliente')" tabindex="6">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="tarifa">Tarifa</label>
                    <input type="text" id="tarifa" readonly autocomplete="off">
                    <input type="button" value="..." class="btn-dark" onclick="openWin('tarifa')" tabindex="7">
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>

        <div class="form-group my-2 col-md-10">
            <h5>Tarifas</h5>
        </div>

        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="tarifa_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Nombre</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('tarifa')" tabindex="8">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('tarifa')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="edit('tarifa')">Editar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fechae">Fecha entrada</label>
                    <input type="date" id="fechae" tabindex="9">
                </div>
                <div class="form-group">
                    <label for="fechas">Fecha Salida</label>
                    <input type="date" id="fechas" tabindex="11">
                </div>
                <div class="form-group">
                    <label for="habi">Habitacion</label>
                    <select id="habi" tabindex="13">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($habitaciones as $habitacion)
                        <option class="hidden" name="combo_habi[]" value={{ $habitacion->id }}>{{ $habitacion->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="horae">Hora entrada</label>
                    <input type="time" id="horae" tabindex="10">
                </div>
                <div class="form-group">
                    <label for="horas">Hora salida</label>
                    <input type="time" id="horas" tabindex="12">
                </div>
            </div>
        </div>

        <div class="form-group mb-4 col-md-10">
            <h5>Habitacion</h5>
        </div>

        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="habitacion_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>

                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Habitacion</th>
                                <th>Fecha entrada</th>
                                <th>Fecha salida</th>
                                <th>Hora entrada</th>
                                <th>Hora salida</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('habitacion')" tabindex="14">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('habitacion')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="edit('habitacion')">Editar</button>
                </div>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="habitacion">Habitacion</label>
                    <select id="habitacion" tabindex="15">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($habitaciones as $habitacion)
                        <option class="hidden" name="combo_habi[]" value={{ $habitacion->id }}>{{ $habitacion->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="persona">Persona</label>
                    <input type="text" id="persona" readonly autocomplete="off">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('persona')" tabindex="16">
                </div>
            </div>
        </div>

        <div class="form-group mb-4 col-md-10">
            <h5>Huespedes</h5>
        </div>

        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="habitacion_huespedes" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Persona</th>
                                <th>Id</th>
                                <th>Habitacion</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('huesped')" tabindex="17">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('huesped')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="edit('huesped')">Editar</button>
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
    function add(table) {
        var x = [];
        if (table === "tarifa") {
            var val = parseInt(document.getElementById('tarifa').value);
            //console.log(val);
            if (Number.isNaN(val)) {
                alert("Cargar campo primero");
                return false;
            }
            var path = "{{route('estadia.tarifa')}}";
            var table = "#tarifa_table"
        }

        if (table === "huesped") {
            var h = document.getElementById("habitacion");
            if (h.options[h.selectedIndex].value === "" || document.getElementById('persona').value === "") {
                alert("Cargar campos primero");
                return false;
            }
            var val = document.getElementById('persona').value;
            val = val.split('-');
            var path = "{{route('estadia.persona')}}";
            var table = "#habitacion_huespedes"
        }

        if (table === "habitacion") {
            //console.log(val);
            var e = document.getElementById("habi");
            var x = [];
            x[0] = e.options[e.selectedIndex].value;
            x[1] = e.options[e.selectedIndex].text;
            x[2] = document.getElementById("fechae").value;
            x[3] = document.getElementById("fechas").value;
            x[4] = document.getElementById("horae").value;
            x[5] = document.getElementById("horas").value;
            if (e.options[e.selectedIndex].value === "" || document.getElementById("fechae").value === "" ||
                document.getElementById("fechas").value === "" || document.getElementById("horae").value === "" ||
                document.getElementById("horas").value === "") {
                alert("Cargar campos primero");
                //console.log(x);
                return false;
            }
            if (x[2] > x[3]) {
                alert("Fecha entrada no puede ser mayor");
                //console.log(x);
                return false;
            }
            // var val = parseInt(document.getElementById('tarifa').value);
            var path = "empty";
            var table = "#habitacion_table"
            //console.log(x);
            addTable(x, table);
        }

        if (table === "estadia_reserva") {
            remove_all()
            for (let index = 0; index < document.getElementsByName("combo_habi[]").length; index++) {
                document.getElementsByName("combo_habi[]")[index].setAttribute("class", "hidden");
            }
            $('.hidden').hide();
            var path = "{{route('estadia.reserva')}}";
            //var table = "#orden_table"
            var val = parseInt(document.getElementById("reserva").value);
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: path,
                data: {
                    id: val
                },
                success: function(data) {
                    //alert(data.presupuesto_);
                    //console.log(data);
                    //alert(data.tarifas[0].descripcion);
                    //$('#tarifa_table').bootstrapTable('insertRow', {index: 0, row: [1,"hola"]})
                    //console.log([1,"hola"]);
                    //addTable(data, table)
                    document.getElementById("cliente").value = data.reservas[0].clientes_id;
                    document.getElementById("operador").value = data.reservas[0].id_operador;
                    document.getElementById("tipoc").value = data.reservas[0].tipo_cliente_id;
                    add_data(data);
                    //var x = [];
                    //x[0] = de.value;

                }
            });
            path = "empty";
        }

        function add_data(data) {

            //console.log(data);
            //var data1 = {array: ["hola","hola"]};
            //console.log(data1);
            //data.articulos.shift();
            //console.log(data);
            //x[0] = de.value;
            var table = "#tarifa_table"
            var path = "empty";
            lenght_data = data.tarifas.length;
            for (let index = 0; index < lenght_data; index++) {
                //x[0] = data.articulos[0].cantidad;
                //x[1] = data.articulos[0].precio;
                //x[2] = data.articulos[0].porcentaje;
                addTable(data, table);
                //console.log(data);
                data.tarifas.shift();
                //console.log(data);
            }
            var table = "#habitacion_table"
            var path = "empty";
            lenght_data = data.reserva_habitaciones.length;
            for (let index = 0; index < lenght_data; index++) {
                x[0] = data.reserva_habitaciones[0].id_habitaciones;
                x[1] = data.reserva_habitaciones[0].descripcion;
                x[2] = data.reserva_habitaciones[0].entrada;
                x[3] = data.reserva_habitaciones[0].salida;
                x[4] = data.reserva_habitaciones[0].hora_entrada;
                x[5] = data.reserva_habitaciones[0].hora_salida;
                addTable(x, table);
                //addTable(data, table);
                //console.log(data);
                data.reserva_habitaciones.shift();
                //console.log(data);
            }
            var table = "empty";
            var path = "empty";
            lenght_data = data.personas.length;
            for (let index = 0; index < lenght_data; index++) {
                $("#habitacion_huespedes").bootstrapTable('insertRow', {
                    index: 0,
                    row: [data.personas[0].ciudad_id + "-" + data.personas[0].nro_documento,
                        data.personas[0].nombre + " " + data.personas[0].apellido,
                        data.personas[0].habitacion_id,
                        data.personas[0].descripcion +
                        '<input type="hidden" name ="habitacion_huesped[]" value=' + data.personas[0].habitacion_id + '>' +
                        '<input type="hidden" name ="persona_ciudad[]" value=' + data.personas[0].ciudad_id + '>' +
                        '<input type="hidden" name ="persona_pais[]" value=' + data.personas[0].pais_id + '>' +
                        '<input type="hidden" name ="persona_documento[]" value=' + data.personas[0].nro_documento + '>'
                    ]
                })
                //addTable(x, table);
                //addTable(data, table);
                //console.log(data);
                data.personas.shift();
                //console.log(data);
            }

        }

        if (path !== "empty") {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: path,
                data: {
                    id: val
                },
                success: function(data) {
                    //alert(data.id);
                    //console.log(data);
                    //alert(data.tarifas[0].descripcion);
                    //$('#tarifa_table').bootstrapTable('insertRow', {index: 0, row: [1,"hola"]})
                    //console.log([1,"hola"]);
                    addTable(data, table)
                }
            });
        }

        function addTable(data, table) {
            if (table === "#tarifa_table") {
                var name_tarifa = document.getElementsByName("tarifa[]");
                for (let index = 0; index < name_tarifa.length; index++) {
                    const element = name_tarifa[index];
                    if (element.value == data.tarifas[0].id) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }
                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [data.tarifas[0].id,
                        data.tarifas[0].descripcion +
                        '<input type="hidden" name ="tarifa[]" value=' + data.tarifas[0].id + '>',
                        data.tarifas[0].habitacion_id
                    ]
                })
                //console.log(data.tarifas[0].habitacion_id);
                // var combo_habitacion = document.getElementsByClassName("hidden");
                var combo_habitacion = document.getElementsByName("combo_habi[]");
                //console.log(combo_habitacion);
                //console.log(combo_habitacion.value);
                //console.log(combo_habitacion.text);
                //console.log(combo_habitacion[1]);
                for (let index = 0; index < combo_habitacion.length; index++) {
                    const element = combo_habitacion[index];
                    if (element.value == data.tarifas[0].habitacion_id) {
                        //console.log(element.value);
                        element.setAttribute("class", "show");
                        $('.show').show();
                    }
                }

                document.getElementById("tarifa").value = "";
            }
            if (table === "#habitacion_huespedes") {
                var e = document.getElementById("habitacion");
                var id_hues = document.getElementById('persona').value;
                var name_ciudad = document.getElementsByName("persona_ciudad[]");
                var name_documento = document.getElementsByName("persona_documento[]");
                for (let index = 0; index < name_ciudad.length; index++) {
                    const element = name_ciudad[index];
                    const element1 = name_documento[index];
                    const element2 = element.value + "-" + element1.value;
                    if (element2 == id_hues) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }

                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [document.getElementById('persona').value,
                        data.personas[0].nombre + " " + data.personas[0].apellido,
                        e.options[e.selectedIndex].value,
                        e.options[e.selectedIndex].text +
                        '<input type="hidden" name ="habitacion_huesped[]" value=' + e.options[e.selectedIndex].value + '>' +
                        '<input type="hidden" name ="persona_ciudad[]" value=' + val[0] + '>' +
                        '<input type="hidden" name ="persona_pais[]" value=' + data.personas[0].pais_id + '>' +
                        '<input type="hidden" name ="persona_documento[]" value=' + val[1] + '>'
                    ]
                })
                document.getElementById('persona').value = "";
                var e = document.getElementById("habitacion");
                e.value = "";
            }
            if (table === "#habitacion_table") {
                var name_habitacion = document.getElementsByName("habitacion[]");
                for (let index = 0; index < name_habitacion.length; index++) {
                    const element = name_habitacion[index];
                    if (element.value == data[0]) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }
                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [data[0], data[1], showDate(data[2]), showDate(data[3]), data[4], data[5] +
                        '<input type="hidden" name ="habitacion[]" value=' + data[0] + '>' +
                        '<input type="hidden" name ="f_entrada[]" value=' + data[2] + '>' +
                        '<input type="hidden" name ="f_salida[]" value=' + data[3] + '>' +
                        '<input type="hidden" name ="h_entrada[]" value=' + data[4] + '>' +
                        '<input type="hidden" name ="h_salida[]" value=' + data[5] + '>'
                    ]
                })
                var e = document.getElementById("habi");
                e.value = "";
                document.getElementById("fechae").value = "";
                document.getElementById("fechas").value = "";
                document.getElementById("horae").value = "";
                document.getElementById("horas").value = "";
            }
        }

    }
    var id_delete = null;
    $('#tarifa_table, #habitacion_table, #habitacion_huespedes').on('click-row.bs.table', function(e, row, $element, field) {
        id_delete = row;
        //console.log(id_delete[2]);
        //$("#tarifa_table").bootstrapTable('remove', {field: 0, values: [1]});
        //console.log($element.index());
        //var d = $("#tarifa_table").bootstrapTable('getData');
        // console.log(d);
        // console.log(d[0][0]);
        // console.log(d.length);
    })

    $('#tarifa_table, #habitacion_table, #habitacion_huespedes').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
    });

    function remove_all() {
        $("#tarifa_table").bootstrapTable('removeAll');
        $("#habitacion_huespedes").bootstrapTable('removeAll');
        $("#habitacion_table").bootstrapTable('removeAll');
    }

    function remove(table_remove) {
        if (id_delete == null) {
            alert("Seleccionar fila primero");
            return false;
        }
        //console.log(id_delete[0]);
        //const combo_habi_edit = document.getElementsByClassName("show");
        //console.log(combo_habi_edit);
        //console.log(combo_habi_edit);
        if (table_remove === "tarifa") {
            var table_rem = "#tarifa_table";
            const combo_habi_edit = document.getElementsByName("combo_habi[]");
            hide(combo_habi_edit);
        }
        if (table_remove === "huesped") {
            var table_rem = "#habitacion_huespedes";
        }
        if (table_remove === "habitacion") {
            var table_rem = "#habitacion_table";
        }
        $(table_rem).bootstrapTable('remove', {
            field: 0,
            values: [id_delete[0]]
        });
        //var combo_habi_edit = document.getElementsByClassName("show");
        // console.log(combo_habi_edit);

        id_delete = null
        // $("#tarifa_table").bootstrapTable('remove', {field: 'id', values: [id_delete[0]]});
        //$("#tarifa_table").bootstrapTable('updateRow', {index: 0, row: []});
        //  $("#tarifa_table").bootstrapTable('removeAll');
        // $("#tarifa_table").bootstrapTable('removeByUniqueId', id_delete[0]);
    }

    function hide(v) {
        for (let index = 0; index < v.length; index++) {
            const element = v[index];
            // console.log(element);
            //  console.log(index);
            if (element.value == id_delete[2]) {
                //  console.log(element.value);
                element.setAttribute("class", "hidden");
                $('.hidden').hide();
            }
        }
    }

    function edit(table_edit) {
        if (id_delete == null) {
            alert("Seleccionar fila primero");
            return false;
        }
        //console.log(id_delete[0]);
        if (table_edit === "tarifa") {
            var table_edt = "#tarifa_table";
            const combo_habi_edit1 = document.getElementsByName("combo_habi[]");
            hide(combo_habi_edit1);
        }
        if (table_edit === "huesped") {
            var table_edt = "#habitacion_huespedes";
        }
        if (table_edit === "habitacion") {
            var table_edt = "#habitacion_table";
        }
        $(table_edt).bootstrapTable('remove', {
            field: 0,
            values: [id_delete[0]]
        });
        id_delete = null
        add(table_edit);
    }

    function showDate(d) {
        var b = d.split('-')
        return b[2] + '/' + b[1] + '/' + b[0];
    }

    function openWin(w) {
        if (w == "cliente") {
            myWindow = window.open("{{ route('searcher.clientes') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "reserva") {
            myWindow = window.open("{{ route('searcher.reservas') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "tarifa") {
            myWindow = window.open("{{ route('searcher.tarifas') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "persona") {
            myWindow = window.open("{{ route('searcher.personas') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
    }

    window.addEventListener('focus', play);

    function play() {
        // console.log("hola");
        var clientes = localStorage.getItem("clientes");
        var reservas = localStorage.getItem("reservas");
        var tarifas = localStorage.getItem("tarifas");
        var personas = localStorage.getItem("personas");

        if (clientes != "nothing" && clientes != null) {
            document.getElementById("cliente").value = clientes;
        }
        if (reservas != "nothing" && reservas != null) {
            document.getElementById("reserva").value = reservas;
            add("estadia_reserva")
        }
        if (tarifas != "nothing" && tarifas != null) {
            document.getElementById("tarifa").value = tarifas;
        }
        if (personas != "nothing" && personas != null) {
            document.getElementById("persona").value = personas;
        }

        localStorage.removeItem("clientes");
        localStorage.removeItem("reservas");
        localStorage.removeItem("tarifas");
        localStorage.removeItem("personas");
    }

    $(".readonly").on('keydown paste', function(e) {
        e.preventDefault();
    });

    function validateForm() {
        var taf = document.getElementsByName("tarifa[]");
        if (taf.length == 0) {
            alert("Cargar al menos una tarifa");
            return false;
        }
        var habi = document.getElementsByName("habitacion[]");
        if (habi.length == 0) {
            alert("Cargar al menos una habitacion");
            return false;
        }
        var hues1 = document.getElementsByName("persona_documento[]");
        if (hues1.length == 0) {
            alert("Cargar al menos un huesped");
            return false;
        }
        //console.log(taf);
        // console.log(taf.length);
        //console.log(x[0]);
        //console.log(x[0].value);
    }

    $('.hidden').hide();
    $('.show').show();

    function mensaje_grabar() {
        return confirm('Desea grabar el registro');
    }
</script>

@endsection