@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('title','Nota de debito agregar')

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Nota de debito agregar')

@section('content')

<form onsubmit="return validateForm()" method="POST" action="{{route('nota_de_debito.store')}}">
    @csrf

    <div class="container" style="margin-top:30px">
        <div class="row">
            @if (session('error_')!==null)
            <div class="col-md-12 mb-3">
                <div class="alert alert-danger">
                    <ul>
                        <li>{{ session('error_') }}</li>
                    </ul>
                </div>
            </div>
            @endif
            <div class="col-md-4">
                <div class="form-group">
                    <label for="numero"> Numero </label>
                    <input type="text" id="numero" name="numero" required readonly value="{{$numero}}">
                </div>
                <div class="form-group">
                    <label for="fechae">Fecha</label>
                    <input type="date" id="fecha" name="fecha" required value="{{\Carbon\Carbon::now(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                </div>
                <div class="form-group">
                    <label for="factura">Factura</label>
                    <input type="text" id="factura" name="factura" class="readonly" required autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('factura')">
                </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="timbrado"> Timbrado </label>
                    <input type="text" id="timbrado" name="timbrado" required readonly value="{{$timbrado[0]->nro}}">
                </div>
                <div class="form-group">
                    <label for="importe"> Importe </label>
                    <input type="text" id="importe" name="importe" value="0" min="0" readonly required>
                </div>
                <div class="form-group">
                    <label for="timbradof"> Timbrado fac.</label>
                    <input type="text" id="timbradof" name="timbradof" required readonly>
                </div>
            </div>
            <div class="col-md-4">

                <div class="form-group">
                    <label for="concepto">Concepto</label>
                    <textarea autofocus id="concepto" cols="30" rows="4" name="concepto" maxlength="100" required tabindex="1"></textarea>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="cantidad">Cantidad</label>
                    <input type="number" id="cantidad" value="" min="1" max="1000000000">
                </div>
                <div class="form-group">
                    <label for="precio">Precio</label>
                    <input type="number" id="precio" value="" min="0" max="1000000000">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="descripcion">Descripcion</label>
                    <input type="text" id="descripcion">
                </div>
                <div class="form-group">
                    <label for="iva">Iva</label>
                    <select id="iva">
                        <option value="">--Selecciona una opción--</option>
                        @foreach($ivas as $iva)
                        <option value={{ $iva->porcentaje }}>{{ $iva->descripcion }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group my-2 col-md-10">
            <h5>Nota de debito detalle</h5>
        </div>
        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="nota_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Descripcion</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Importe</th>
                                <th>Iva</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('nota')" tabindex="8">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('nota')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" style="display: none;" onclick="edit('nota')">Editar</button>
                </div>
            </div>
        </div>
    </div>

    <div class="row form-group">
        <div class="col-6 form-group">
        </div>
        <div class="col-3 ">
            <label for="total_iva" class="form-group1">
                <span> Total iva</span>
                <input type="text" id="total_iva" readonly>
            </label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-6 form-group">
        </div>
        <div class="col-3 ">
            <label for="subtotal" class="form-group1">
                <span> Subtotal</span>
                <input type="text" id="subtotal" readonly>
            </label>
        </div>
    </div>
    <div class="row form-group">
        <div class="col-6 form-group">
        </div>
        <div class="col-3 ">
            <label for="total" class="form-group1">
                <span> Total</span>
                <input type="text" id="total" readonly>
            </label>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-10">
                <div class="d-flex flex-wrap justify-content-md-around ">
                    <div class="p-2 mx-auto"><button type="submit" class="btn btn-dark" onclick="return mensaje_grabar()" tabindex="18">GRABAR</button></div>
                    <div class="p-2 mx-auto"><button type="reset" class="btn btn-dark" onclick="remove_all()">CANCELAR</button></div>
                    <div class="p-2 mx-auto"><button type="button" onclick="location.href = '{{ route('nota_de_debito.index') }}'" class="btn btn-dark">SALIR</button></div>
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
        var x = [];
        if (table === "nota") {
            //console.log(val);
            var ca = document.getElementById("cantidad");
            var de = document.getElementById("descripcion");
            var pr = document.getElementById("precio");
            var iv = document.getElementById("iva");
            var x = [];
            x[0] = de.value;
            x[1] = ca.value;
            x[2] = pr.value;
            x[3] = iv.value;
            x[4] = iv.text;
            if (x[0] === "" || x[1] === "" ||
                x[2] === "" || x[3] === "") {
                alert("Cargar campos primero");
                //console.log(x);
                return false;
            }
            if (parseInt(x[1]) <= 0) {
                alert("Cantidad debe ser mayor a cero");
                //console.log(x);
                return false;
            }
            // var val = parseInt(document.getElementById('tarifa').value);
            var path = "empty";
            var table = "#nota_table"
            //console.log(x);
            addTable(x, table);
        }

        if (table === "nota_factura") {
            remove_all()
            var path = "{{route('n_debito.factura')}}";
            var table = "#nota_table"
            var val = [];
            val[0] = document.getElementById("factura").value;
            val[1] = document.getElementById("timbradof").value;
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
                    // console.log(data);
                    //alert(data.tarifas[0].descripcion);
                    //$('#tarifa_table').bootstrapTable('insertRow', {index: 0, row: [1,"hola"]})
                    //console.log([1,"hola"]);
                    //addTable(data, table)
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
            lenght_data = data.factura.length;
            for (let index = 0; index < lenght_data; index++) {
                x[0] = data.factura[0].descripcion;
                x[1] = data.factura[0].cantidad;
                x[2] = data.factura[0].precio;
                x[3] = data.factura[0].porcentaje;
                addTable(x, table);
                //console.log(data);
                data.factura.shift();
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
            if (table === "#nota_table") {
                id_monto += 1;
                var importe = 0;
                importe = (parseInt(data[2]) * parseInt(data[1]));
                var iva = 0;
                iva = parseInt(importe / parseInt(data[3]));
                $(table).bootstrapTable('insertRow', {
                    index: 0,
                    row: [id_monto, data[0], data[1], parseInt(data[2]).format(0, 3, '.', ','), importe.format(0, 3, '.', ','), iva.format(0, 3, '.', ',') +
                        '<input type="hidden" name ="descripcion_detalle[]" value=' + data[0].replace(/ /g, "_") + '>' +
                        '<input type="hidden" name ="precio_detalle[]" value=' + data[2] + '>' +
                        '<input type="hidden" name ="cantidad_detalle[]" value=' + data[1] + '>' +
                        '<input type="hidden" name ="iva_detalle[]" value=' + data[3] + '>'
                    ]
                })
                total_iva += iva;
                subtotal += importe;
                total = total_iva + subtotal;

                document.getElementById("total_iva").value = total_iva.format(0, 3, '.', ',');
                document.getElementById("subtotal").value = subtotal.format(0, 3, '.', ',');
                document.getElementById("total").value = total.format(0, 3, '.', ',');
                document.getElementById("importe").value = (total.format(0, 3, '.', ',')).replace(".", "");

                document.getElementById("cantidad").value = "";
                document.getElementById("descripcion").value = "";
                document.getElementById("precio").value = "";
                document.getElementById("iva").value = "";
            }
        }

    }
    var id_delete = null;
    $('#nota_table, #cheque_table').on('click-row.bs.table', function(e, row, $element, field) {
        id_delete = row;
        //console.log(id_delete[2]);
        //$("#tarifa_table").bootstrapTable('remove', {field: 0, values: [1]});
        //console.log($element.index());
        //var d = $("#tarifa_table").bootstrapTable('getData');
        // console.log(d);
        // console.log(d[0][0]);
        // console.log(d.length);
    })

    $('#nota_table, #cheque_table, #habitacion_huespedes').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
    });

    function remove_all() {
        $("#nota_table").bootstrapTable('removeAll');
        total_iva = 0;
        subtotal = 0;
        total = total_iva + subtotal;
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
        if (table_remove === "nota") {
            var table_rem = "#nota_table";
            var importe = 0;
            importe = parseInt(id_delete[4].replace(".", ""));
            var iva = 0;
            iva = parseInt(id_delete[5].replace(".", ""));

            total_iva -= iva;
            subtotal -= importe;
            total = total_iva + subtotal;

            document.getElementById("total_iva").value = total_iva.format(0, 3, '.', ',');
            document.getElementById("subtotal").value = subtotal.format(0, 3, '.', ',');
            document.getElementById("total").value = total.format(0, 3, '.', ',');
            document.getElementById("importe").value = total.format(0, 3, '.', ',');
        }
        if (table_remove === "cheque") {
            var table_rem = "#cheque_table";
            mon_cheque = parseInt(id_delete[2].replace(".", ""));
            total_entregado -= mon_cheque;
            document.getElementById("te").value = total_entregado.format(0, 3, '.', ',');
            entregado();
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
        if (table_edit === "tarjeta") {
            var table_edt = "#tarjeta_table";
            mon_tarjeta = parseInt(id_delete[7].replace(".", ""));
            total_entregado -= mon_tarjeta;
            document.getElementById("te").value = total_entregado.format(0, 3, '.', ',');
            entregado();
        }
        if (table_edit === "cheque") {
            var table_edt = "#cheque_table";
            mon_cheque = parseInt(id_delete[2].replace(".", ""));
            total_entregado -= mon_cheque;
            document.getElementById("te").value = total_entregado.format(0, 3, '.', ',');
            entregado();
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
        if (w == "factura") {
            myWindow = window.open("{{ route('searcher.factura') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
        if (w == "apertura") {
            myWindow = window.open("{{ route('searcher.apertura_cierre') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
    }

    window.addEventListener('focus', play);

    function play() {
        // console.log("hola");
        var factura = localStorage.getItem("factura");
        var facturaf = localStorage.getItem("facturaf");
        var cuentas_monto = localStorage.getItem("cuentas_monto");
        var apertura = localStorage.getItem("apertura_cierre");

        if (factura != "nothing" && factura != null) {
            document.getElementById("factura").value = factura;
            document.getElementById("timbradof").value = facturaf;
            add("nota_factura");
        }
        if (apertura != "nothing" && apertura != null) {
            document.getElementById("apertura").value = apertura;
        }
        if (cuentas_monto != "nothing" && cuentas_monto != null) {
            document.getElementById("monto").value = cuentas_monto;
            entregado();
        }
        localStorage.removeItem("factura");
        localStorage.removeItem("facturaf");
        localStorage.removeItem("apertura_cierre");
        localStorage.removeItem("cuentas_monto");
    }

    $(".readonly").on('keydown paste', function(e) {
        e.preventDefault();
    });

    function validateForm() {
        var taf = document.getElementsByName("descripcion_detalle[]");
        if (taf.length == 0) {
            alert("Cargar al menos un detalle");
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
    document.querySelector('#numero').addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
    document.querySelector('#precio').addEventListener("keypress", function(evt) {
        if (evt.which != 8 && evt.which != 0 && evt.which < 48 || evt.which > 57) {
            evt.preventDefault();
        }
    });
    document.querySelector('#importe').addEventListener("keypress", function(evt) {
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