@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('title','Servicios turismo agregar')

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Servicios turismo agregar')

@section('content')

<form onsubmit="return validateForm()" method="POST" action="{{route('servicios_turismo.store')}}">
    @csrf

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="id"> Id </label>
                    <input type="text" id="id" name="id">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <select id="nombre" required name="nombre">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($nombres as $nombre)
                        <option value={{ $nombre->id }}>{{ $nombre->nombre }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" id="fecha" name="fecha" required value="{{\Carbon\Carbon::now(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                </div>
                <div class="form-group">
                    <label for="descripcion"> Descripcion </label>
                    <input type="text" id="descripcion" name="descripcion" required>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="realizado">Realizado</label>
                    <select id="realizado" required name="realizado">
                        <option value="">--Selecciona una opción--</option>
                        <option value="SI">Si</option>
                        <option value="NO">No</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total"> Total </label>
                    <input type="number" id="total" name="total" value="0" min="0" max="1000000000" readonly>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="huesped">Huesped</label>
                    <input type="text" id="huesped" class="readonly" autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('huesped')">
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>

        <div class="form-group my-2 col-md-10">
            <h5>Servicio Detalle</h5>
        </div>
        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="huesped_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Huesped</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('huesped')" tabindex="8">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('huesped')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" style="display: none;" onclick="edit('huesped')">Editar</button>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                <label for="fecha1">Fecha</label>
                    <input type="date" id="fecha1" tabindex="9">
                </div>
                <div class="form-group">
                <label for="hora">Hora</label>
                    <input type="time" id="hora" tabindex="10">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="spa">Turismo</label>
                    <input type="text" id="turismo" class="readonly" autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('turismo')">
                </div>
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" value="" min="1" max="1000000000">
                </div>
            </div>
        </div>

        <div class="form-group my-2 col-md-10">
            <h5>Turismo</h5>
        </div>
        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="turismo_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Turismo</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Fecha</th>
                                <th>Hora</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('turismo')" tabindex="8">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('turismo')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" style="display: none;" onclick="edit('turismo')">Editar</button>
                </div>
            </div>
        </div>
    </div>


    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="d-flex flex-wrap justify-content-md-around ">
                    <div class="p-2 mx-auto"><button type="submit" class="btn btn-dark" onclick="return mensaje_grabar()" tabindex="18">GRABAR</button></div>
                    <div class="p-2 mx-auto"><button type="reset" class="btn btn-dark" onclick="remove_all()">CANCELAR</button></div>
                    <div class="p-2 mx-auto"><button type="button" onclick="location.href = '{{ route('servicios_turismo.index') }}'" class="btn btn-dark">SALIR</button></div>
                </div>
            </div>
        </div>
    </div>
    </div>

</form>

<script>
    var id_monto = 0;
    var importe = 0;
    var subtotal = 0;
    var total_iva = 0;
    var total = 0;


    function add(table) {

        if (table === "huesped") {
            //console.log(val);
            var val = document.getElementById("huesped").value;

            if (val === "") {
                alert("Cargar campos primero");
                //console.log(x);
                return false;
            }
            // var val = parseInt(document.getElementById('tarifa').value);
            //var path = "empty";
            var path = "{{route('servicios_spa.huesped')}}";
            var table = "#huesped_table"
            //console.log(x);
            // addTable(x, table);
        }

        if (table === "turismo") {
            //console.log(val);
            var can = document.getElementById("cantidad").value;
            var fech = document.getElementById("fecha1").value;
            var hor = document.getElementById("hora").value;
            var val = parseInt(document.getElementById("turismo").value);
            if (hor === "" || fech === "" || isNaN(parseInt(can)) || isNaN(val)) {
                alert("Cargar campos primero");
                //console.log(x);
                return false;
            }
            if (parseInt(can) <= 0) {
                alert("Cantidad debe ser mayor a cero");
                //console.log(x);
                return false;
            }
            // var val = parseInt(document.getElementById('tarifa').value);
            //var path = "empty";
            var path = "{{route('servicios_turismo.turi')}}";
            var table = "#turismo_table"
            //console.log(x);
            // addTable(x, table);
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
            if (table === "#huesped_table") {

                var name_articulo = document.getElementsByName("huesped_detalle[]");
                for (let index = 0; index < name_articulo.length; index++) {
                    const element = name_articulo[index];
                    if (element.value == data.huespedes[0].codigo) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }

                //id_monto += 1;
                /* var importe = 0;
                 importe = (parseInt(x[0]) * parseInt(x[1]));
                 var iva = 0;
                 iva = parseInt(importe / parseInt(x[2]));*/
                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [data.huespedes[0].id, data.huespedes[0].nombre + " " + data.huespedes[0].apellido +
                        '<input type="hidden" name ="huesped_detalle[]" value=' + data.huespedes[0].id + '>'
                    ]
                })
                /*total_iva += iva;
                subtotal += importe;
                total = total_iva + subtotal;

                document.getElementById("total_iva").value = total_iva.format(0, 3, '.', ',');
                document.getElementById("subtotal").value = subtotal.format(0, 3, '.', ',');
                document.getElementById("total").value = total.format(0, 3, '.', ',');
                //document.getElementById("importe").value = (total.format(0, 3, '.', ',')).replace(".","");

                document.getElementById("cantidad").value = "";
                document.getElementById("articulo").value = "";
                document.getElementById("precio").value = "";
                document.getElementById("iva").value = "";*/
                document.getElementById("huesped").value = "";
            }
            if (table === "#turismo_table") {

                var name_articulo = document.getElementsByName("turismo_detalle[]");
                for (let index = 0; index < name_articulo.length; index++) {
                    const element = name_articulo[index];
                    if (element.value == data.turismos[0].id) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }
                
                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [data.turismos[0].id, data.turismos[0].destino, can, data.turismos[0].precio.format(0, 3, '.', ','),showDate(fech),hor+
                        '<input type="hidden" name ="turismo_detalle[]" value=' + data.turismos[0].id + '>' +
                        '<input type="hidden" name ="cantidad_detalle[]" value=' + parseInt(can) + '>' + 
                        '<input type="hidden" name ="fecha_detalle[]" value=' + fech + '>' +
                        '<input type="hidden" name ="hora_detalle[]" value=' + hor + '>' 
                    ]
                })
                
                total += parseInt(parseInt(can) * data.turismos[0].precio);

                //document.getElementById("total_iva").value = total_iva.format(0, 3, '.', ',');
                //document.getElementById("subtotal").value = subtotal.format(0, 3, '.', ',');
                document.getElementById("total").value = total;
                //document.getElementById("importe").value = (total.format(0, 3, '.', ',')).replace(".","");

                document.getElementById("cantidad").value = "";
                document.getElementById("turismo").value = "";
                document.getElementById("hora").value = "";
                document.getElementById("fecha1").value = "";
            }
        }

    }
    var id_delete = null;
    $('#huesped_table, #turismo_table').on('click-row.bs.table', function(e, row, $element, field) {
        id_delete = row;
        //console.log(id_delete[4]);
        //$("#tarifa_table").bootstrapTable('remove', {field: 0, values: [1]});
        //console.log($element.index());
        //var d = $("#tarifa_table").bootstrapTable('getData');
        // console.log(d);
        // console.log(d[0][0]);
        // console.log(d.length);
    })

    $('#huesped_table, #turismo_table, #habitacion_huespedes').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
    });

    function remove_all() {
        $("#huesped_table").bootstrapTable('removeAll');
        $("#turismo_table").bootstrapTable('removeAll');

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
        if (table_remove === "turismo") {
            var table_rem = "#turismo_table";

            total -=  ( parseInt(id_delete[2]) * parseInt(id_delete[3].replace(".", "")));

            document.getElementById("total").value = total;
        }
        if (table_remove === "huesped") {
            var table_rem = "#huesped_table";
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
        if (table_edit === "turismo") {
            var table_rem = "#turismo_table";

            total -=  ( parseInt(id_delete[2]) * parseInt(id_delete[3].replace(".", "")));

            document.getElementById("total").value = total;
        }
        if (table_edit === "cheque") {
            var table_edt = "#cheque_table";
            mon_cheque = parseInt(id_delete[2].replace(".", ""));
            total_entregado -= mon_cheque;
            document.getElementById("te").value = total_entregado.format(0, 3, '.', ',');
            entregado();
        }
        if (table_edit === "huesped") {
            var table_edt = "#huesped_table";
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
        if (w == "huesped") {
            myWindow = window.open("{{ route('searcher.huesped') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "turismo") {
            myWindow = window.open("{{ route('searcher.turismo') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "requisicion") {
            myWindow = window.open("{{ route('searcher.requisicion') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
    }

    window.addEventListener('focus', play);

    function play() {
        // console.log("hola");
        var huesped = localStorage.getItem("huesped");
        var turismo = localStorage.getItem("turismo");
        var requisicion = localStorage.getItem("requisicion");

        if (huesped != "nothing" && huesped != null) {
            document.getElementById("huesped").value = huesped;
        }
        if (requisicion != "nothing" && requisicion != null) {
            document.getElementById("requisicion").value = requisicion;
        }
        if (turismo != "nothing" && turismo != null) {
            document.getElementById("turismo").value = turismo;
        }
        localStorage.removeItem("huesped");
        localStorage.removeItem("requisicion");
        localStorage.removeItem("turismo");
    }

    $(".readonly").on('keydown paste', function(e) {
        e.preventDefault();
    });

    function validateForm() {
        var taf = document.getElementsByName("huesped_detalle[]");
        if (taf.length == 0) {
            alert("Cargar al menos un huesped");
            return false;
        }
        var taf1 = document.getElementsByName("turismo_detalle[]");
        if (taf1.length == 0) {
            alert("Cargar al menos un spa o sauna detalle");
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

    document.querySelector('#cantidad').addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
    document.querySelector('#total').addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });




    Number.prototype.format = function(n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };
</script>

@endsection