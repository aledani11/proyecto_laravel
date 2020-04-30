@extends ('layout')

@section('meta')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@endsection

@section('link')
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.css">
@endsection

@section('title','Factura agregar')

@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/bootstrap-table@1.15.5/dist/bootstrap-table.min.js"></script>
<script src="/js/bootstrap-table-es-MX.js"></script>
@endsection

@section('header', 'Factura agregar')

@section('content')

<form onsubmit="return validateForm()" method="POST" action="{{route('factura.store')}}">
    @csrf

    <div class="container" style="margin-top:30px">
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="numero"> Numero </label>
                    <input type="text" id="numero" name="codigo" readonly>
                </div>
                <div class="form-group">
                    <label for="condicion">Condicion</label>
                    <select id="condicion" required name="condicion" tabindex="2" onchange="condition()">
                        <option value="">--Selecciona una opción--</option>
                        <option value="Credito">Credito</option>
                        <option value="Contado">Contado</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="canc"> Cantidad de Cuotas </label>
                    <input type="number" id="canc" name="cancuo" value="0" min="0" max="24" tabindex="1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="fecha">Fecha</label>
                    <input type="date" name="fecha" id="fecha" required value="{{\Carbon\Carbon::now(new DateTimeZone('America/Asuncion'))->format('Y-m-d')}}">
                </div>
                <div class="form-group">
                    <label for="cliente">Cliente</label>
                    <input type="text" id="cliente" name="cliente" required class="readonly" autocomplete="off" style="caret-color: transparent !important;">
                    <input type="button" value="..." class=" btn-dark" onclick="openWin('cliente')" tabindex="6">
                </div>
                <div class="form-group">
                    <label for="plazo"> Plazo </label>
                    <input type="number" id="plazo" name="plazo" value="30" min="0" max="60" tabindex="1">
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="total"> Total </label>
                    <input type="text" id="total" name="total" readonly required tabindex="1">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label for="estadia">Estadia</label>
                    <input type="text" id="estadia" readonly autocomplete="off">
                    <input type="button" value="..." class="btn-dark" onclick="openWin('estadia')" tabindex="7">
                </div>
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="form-group my-2 col-md-10">
            <h5>Estadia</h5>
        </div>
        <div class="row">
            <div class="col-md-10 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="estadia_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Habitacion</th>
                                <th>Entrada</th>
                                <th>Salida</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="col-md-2 form-group">
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="add('estadia')" tabindex="8">Agregar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="remove('estadia')">Quitar</button>
                </div>
                <div class="col-md-12">
                    <button type="button" class="btn btn-dark form-group" onclick="edit('estadia')">Editar</button>
                </div>
            </div>
        </div>
        <div class="form-group my-2 col-md-12">
            <h5>Tarifa</h5>
        </div>
        <div class="row mt-3">
            <div class="col-md-12 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="tarifa_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th data-sortable="true">Id</th>
                                <th>Id_estadia</th>
                                <th>Tarifa</th>
                                <th>Precio</th>
                                <th>Iva</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>


        </div>


        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="total_iva" class="form-group1">
                    <span> Total Iva</span>
                    <input type="text" id="total_iva" readonly>
                </label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="subtotal" class="form-group1">
                    <span> Subtotal</span>
                    <input type="text" id="subtotal" readonly>
                </label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="total1" class="form-group1">
                    <span> Total</span>
                    <input type="text" id="total1" readonly>
                </label>
            </div>
        </div>


        <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
            </div>
        </div>
        <div class="form-group my-2 col-md-12">
            <h5>Servicios</h5>
        </div>
        <div class="row">
            <div class="col-md-12 form-group">
                <div class="table-responsive-md table-hover from-group" style="overflow-y:auto; height:200px">
                    <table id="servicios_table" data-toggle="table" data-classes="table table-bordered table-hover table-md">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>id_estadia</th>
                                <th>Servicio</th>
                                <th>Precio</th>
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
                </div>
                <div class="col-md-12">
                </div>
                <div class="col-md-12">
                </div>
            </div>
        </div>


        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="total_iva1" class="form-group1">
                    <span> Total iva</span>
                    <input type="text" id="total_iva1" readonly>
                </label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="subtotal1" class="form-group1">
                    <span> Subtotal</span>
                    <input type="text" id="subtotal1" readonly>
                </label>
            </div>
        </div>
        <div class="row form-group">
            <div class="col-8 form-group">
            </div>
            <div class="col-3 ">
                <label for="total2" class="form-group1">
                    <span> Total</span>
                    <input type="text" id="total2" readonly>
                </label>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-md-10">
                    <div class="d-flex flex-wrap justify-content-md-around ">
                        <div class="p-2 mx-auto"><button type="submit" class="btn btn-dark" onclick="return mensaje_grabar()" tabindex="18">GRABAR</button></div>
                        <div class="p-2 mx-auto"><button type="reset" class="btn btn-dark" onclick="remove_all()">CANCELAR</button></div>
                        <div class="p-2 mx-auto"><button type="button" onclick="location.href = '{{ route('factura.index') }}'" class="btn btn-dark">SALIR</button></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


</form>

<script>
    var iva_total = 0;
    var subtotal = 0;
    var total1 = 0;
    var iva_total1 = 0;
    var subtotal1 = 0;
    var total2 = 0;

    function add(table) {

        if (table === "estadia") {
            var val = parseInt(document.getElementById('estadia').value);
            //console.log(val);
            if (Number.isNaN(val)) {
                alert("Cargar campo primero");
                return false;
            }
            var path = "{{route('factura.estadia')}}";
            var table = "#estadia_table"
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
                    addTable(data, table)
                }
            });
        }


        function addTable(data, table) {
            if (table === "#estadia_table") {
                var name_estadia = document.getElementsByName("estad[]");
                for (let index = 0; index < name_estadia.length; index++) {
                    const element = name_estadia[index];
                    if (element.value == data.estadias[0].id) {
                        alert("Codigo ya ingresado");
                        return false;
                    }
                }
                for (let index = 0; index < data.estadias.length; index++) {
                    $("#estadia_table").bootstrapTable('insertRow', {
                        index: 0,
                        row: [data.estadias[index].id,
                            data.estadias[index].descripcion,
                            data.estadias[index].entrada,
                            data.estadias[index].salida +
                            '<input type="hidden" name ="estad[]" value=' + data.estadias[index].id + '>'
                        ]
                    })
                }

                for (let index = 0; index < data.tarifa.length; index++) {
                    $("#tarifa_table").bootstrapTable('insertRow', {
                        index: 0,
                        row: [data.tarifa[index].id,
                            data.tarifa[index].estadia_id,
                            data.tarifa[index].descripcion,
                            data.tarifa[index].precio.format(0, 3, '.', ','),
                            (data.tarifa[index].precio / 11).format(0, 3, '.', ',') +
                            '<input type="hidden" name ="tarifa_id[]" value=' + data.tarifa[index].id + '>' +
                            '<input type="hidden" name ="tarifa_iva[]" value=2>'
                        ]
                    })
                    iva_total += (data.tarifa[index].precio / 11);
                    subtotal += data.tarifa[index].precio;
                }
                total1 = iva_total + subtotal;
                document.getElementById("total_iva").value = iva_total.format(0, 3, '.', ',');
                document.getElementById("subtotal").value = subtotal.format(0, 3, '.', ',');
                document.getElementById("total1").value = total1.format(0, 3, '.', ',');

                for (let index = 0; index < data.servicios.length; index++) {
                    $("#servicios_table").bootstrapTable('insertRow', {
                        index: 0,
                        row: [data.servicios[index].esta_servi_id,
                            data.servicios[index].estadia_id,
                            data.servicios[index].servicio,
                            data.servicios[index].precio_servi.format(0, 3, '.', ','),
                            (data.servicios[index].precio_servi / 11).format(0, 3, '.', ',') +
                            '<input type="hidden" name ="estadia_servicios[]" value=' + data.servicios[index].esta_servi_id + '>' +
                            '<input type="hidden" name ="estadia_servi_iva[]" value=2>'
                        ]
                    })
                    iva_total1 += (data.servicios[index].precio_servi / 11);
                    subtotal1 += data.servicios[index].precio_servi;

                }

                total2 = iva_total1 + subtotal1;
                document.getElementById("total_iva1").value = iva_total1.format(0, 3, '.', ',');
                document.getElementById("subtotal1").value = subtotal1.format(0, 3, '.', ',');
                document.getElementById("total2").value = total2.format(0, 3, '.', ',');

                document.getElementById("total").value = (total1 + total2).format(0, 3, '.', ',');



                document.getElementById("estadia").value = "";
            }
            
        }

    }
    var id_delete = null;
    $('#estadia_table').on('click-row.bs.table', function(e, row, $element, field) {
        id_delete = row;
    })

    $('#estadia_table').on('click', 'tbody tr', function(event) {
        $(this).addClass('highlight').siblings().removeClass('highlight');
    });

    function remove_all() {
        $("#tarifa_table").bootstrapTable('removeAll');
        $("#servicios_table").bootstrapTable('removeAll');
        $("#estadia_table").bootstrapTable('removeAll');
    }

    function remove(table_remove) {
        if (id_delete == null) {
            alert("Seleccionar fila primero");
            return false;
        }
        if (table_remove === "estadia") {
            var table_rem = "#estadia_table";
            //var xx = $('#tarifa_table').bootstrapTable('getData');
            //console.log(xx);
            //console.log(xx[0][0]);
           /* $('#tarifa_table').bootstrapTable('remove', {
                field: 1,
                values: [id_delete[0]]
            });
            $('#servicios_table').bootstrapTable('remove', {
                field: 1,
                values: [id_delete[0]]
            });*/
            $("#tarifa_table").bootstrapTable('removeAll');
            $("#servicios_table").bootstrapTable('removeAll');
            $("#estadia_table").bootstrapTable('removeAll');
            iva_total = 0;
            subtotal = 0;
            total1 = 0;
            iva_total1 = 0;
            subtotal1 = 0;
            total2 = 0;
            document.getElementById("total_iva1").value = "";
            document.getElementById("subtotal1").value = "";
            document.getElementById("total2").value = "";
            document.getElementById("total_iva").value = "";
            document.getElementById("subtotal").value = "";
            document.getElementById("total1").value = "";

            document.getElementById("total").value = "";
        }
        /*$(table_rem).bootstrapTable('remove', {
            field: 0,
            values: [id_delete[0]]
        });*/
     

        id_delete = null
        
    }


    function edit(table_edit) {
        if (id_delete == null) {
            alert("Seleccionar fila primero");
            return false;
        }
        if (table_edit === "tarifa") {
            var table_edt = "#estadia_table";
            $("#tarifa_table").bootstrapTable('removeAll');
            $("#servicios_huespedes").bootstrapTable('removeAll');
            $("#estadia_table").bootstrapTable('removeAll');
            iva_total = 0;
            subtotal = 0;
            total1 = 0;
            iva_total1 = 0;
            subtotal1 = 0;
            total2 = 0;
            document.getElementById("total_iva1").value = "";
            document.getElementById("subtotal1").value = "";
            document.getElementById("total2").value = "";
            document.getElementById("total_iva").value = "";
            document.getElementById("subtotal").value = "";
            document.getElementById("total1").value = "";

            document.getElementById("total").value = "";
        }
        /*$(table_edt).bootstrapTable('remove', {
            field: 0,
            values: [id_delete[0]]
        });*/
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
        if (w == "estadia") {
            myWindow = window.open("{{ route('searcher.estadias') }}", "_blank", "width=1000, height=500, menubar=no, top=50, left=250");
        }
    }

    window.addEventListener('focus', play);

    function play() {
        // console.log("hola");
        var clientes = localStorage.getItem("clientes");
        var reservas = localStorage.getItem("reservas");
        var estadias = localStorage.getItem("estadias");

        if (clientes != "nothing" && clientes != null) {
            document.getElementById("cliente").value = clientes;
        }
        if (reservas != "nothing" && reservas != null) {
            document.getElementById("reserva").value = reservas;
        }
        if (estadias != "nothing" && estadias != null) {
            document.getElementById("estadia").value = estadias;
        }

        localStorage.removeItem("clientes");
        localStorage.removeItem("reservas");
        localStorage.removeItem("estadias");
    }

    $(".readonly").on('keydown paste', function(e) {
        e.preventDefault();
    });

    function validateForm() {
        var taf = document.getElementsByName("estad[]");
        if (taf.length == 0) {
            alert("Cargar al menos una estadia");
            return false;
        }
    }

    $('.hidden').hide();
    $('.show').show();

    function mensaje_grabar() {
        return confirm('Desea grabar el registro');
    }
    Number.prototype.format = function(n, x, s, c) {
        var re = '\\d(?=(\\d{' + (x || 3) + '})+' + (n > 0 ? '\\D' : '$') + ')',
            num = this.toFixed(Math.max(0, ~~n));

        return (c ? num.replace('.', c) : num).replace(new RegExp(re, 'g'), '$&' + (s || ','));
    };

    function condition(){
        var sele = document.getElementById("condicion").value;
        if(sele!="" || sele=="Contado"){
            document.getElementById("plazo").value=0;
            document.getElementById("canc").value=0;
            document.getElementById("plazo").setAttribute("readonly", true);
            document.getElementById("canc").setAttribute("readonly", true);
        }
         if(sele=="Credito"){
            document.getElementById("plazo").removeAttribute("readonly");
            document.getElementById("canc").removeAttribute("readonly");
            document.getElementById("plazo").value=30;
            document.getElementById("canc").value=1;
            document.getElementById("plazo").setAttribute("min", 1);
            document.getElementById("canc").setAttribute("min", 1);
        }
    }

</script>

@endsection