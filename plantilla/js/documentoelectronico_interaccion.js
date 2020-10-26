$(function() {

    // $('#descripcionExtra').slideUp();

    inicializar_controles();

    inicializar_tabla_detalle();
    if (productos.length !== undefined) {
        add_to_detalle_producto(productos);
    } //end if

    $(".btn_agregarservicio").hide(500);
    $(".search_document").click(search_document);
    $('input[type=radio][name=tipo_comprobante]').change(function() {
        rellenar_tipo_documento(this.value, $(this).data('tipo'));
    });
    $('#tipo_comprobante_modificado').on('change', function() {
        var tipo_doc = this.value;
        $("#cliente_tipodocumento").empty();
        if (tipo_doc == '01') {
            $('#cliente_tipodocumento').append($("<option></option>")
                .attr("value", '6')
                .text('RUC'));
            $('#cliente_tipodocumento').trigger("change");
            $("#serie_comprobante").val('F001');
            $(".search_document").show();
            $('#cliente_numerodocumento').attr('pattern', '.{11,11}');
            $('#cliente_numerodocumento').attr('title', 'Número de RUC');
        } else if (tipo_doc == '03') {
            $('#cliente_tipodocumento').append($("<option></option>")
                .attr("value", '1')
                .text('DNI'));
            $('#cliente_tipodocumento').trigger("change");
            $(".search_document").show();
            $('#cliente_numerodocumento').attr('pattern', '.{8,8}');
            $('#cliente_numerodocumento').attr('title', 'Número de DNI');
        }
    });
    $('#cliente_tipodocumento').on('change', function() {
        var cliente_tipodocumento = this.value;
        $(".search_document").hide();
        if (cliente_tipodocumento == '1') { // Boleta
            $("#titulo_nombrecliente").html('Nombre del Cliente');
            $("#titulo_numerodocumento").html('N° de DNI');
            $(".search_document").hide();
        } else if (cliente_tipodocumento == '6') { // Factura
            $("#titulo_nombrecliente").html('Razón Social');
            $("#titulo_numerodocumento").html('N° de RUC');
            $(".search_document").hide();
        } else if (cliente_tipodocumento == '5') {
            $("#titulo_nombrecliente").html('Razón Social');
            $("#titulo_numerodocumento").html('N° de RUC');
            $(".search_document").show();
        } else if (cliente_tipodocumento == '2') {
            $("#titulo_nombrecliente").html('Nombre del Cliente');
            $("#titulo_numerodocumento").html('N° de Carné de Extranjería');
        } else if (cliente_tipodocumento == '3') {
            $("#titulo_nombrecliente").html('Nombre del Cliente');
            $("#titulo_numerodocumento").html('N° de Pasaporte');
        } else if (cliente_tipodocumento == '4') {
            $("#titulo_nombrecliente").html('Nombre del Cliente');
            $("#titulo_numerodocumento").html('N° de Cédula');
        } else {
            $("#titulo_nombrecliente").html('Nombre del Cliente');
            $("#titulo_numerodocumento").html('N° de Documento');
        }
    });


    var fecha_actual = new Date().toJSON().slice(0, 10);
    var numaleatorio = Math.floor(100000 + Math.random() * 900000);

    //$("#fecha_comprobante").val(fecha_actual);
    //$("#numero_comprobante").val(numaleatorio);
    var num_comprobante_modificado = 'F001-' + (numaleatorio + 10);
    //$("#num_comprobante_modificado").val(num_comprobante_modificado);

    $("#tipo_venta").on('change', function() {
        var lista_productos = jQuery('#detalle_documento').getDataIDs();
        if (lista_productos.length > 0) {
            alert("Borre todos los registros de la tabla para cambiar el tipo de venta.");
            if ($(this).val() == "PRODUCTOS") {
                $(this).val("SERVICIOS");
            } else if ($(this).val() == "SERVICIOS") {
                $(this).val("PRODUCTOS");
            }
        } else {
            if ($(this).val() == "PRODUCTOS") {
                $("#LabelID").html("Orden de compra:");
                $(".btn_agregarservicio").hide(0);
                $(".btn_agregarproducto").show(0);
            } else if ($(this).val() == "SERVICIOS") {
                $("#LabelID").html("Orden de servicio:");
                $(".btn_agregarproducto").hide(0);
                $(".btn_agregarservicio").show(0);
            }
        }
    });


    $(".btn_agregarproducto").click(function() {
        if ($("#tipo_venta").val() == "PRODUCTOS") {
            $("#frm_producto")[0].reset();
            $("#vm_agregar_articulo").modal("show");
        } else {
            alert("El tipo de venta es servicios");
        }
    });

    $(".btn_agregarservicio").click(function() {
        if ($("#tipo_venta").val() == "SERVICIOS") {
            $("#frm_servicio").trigger("reset");
            $("#frm_servicio")[0].reset()
            $("#vm_agregar_servicio").modal("show");
        } else {
            alert("El tipo de venta es productos.");
        }

    });

    calcular_totales_producto();

    $("#producto_preciounidad").on('input', function() {
        calcular_totales_producto();
    }).on('change', function() {
        calcular_totales_producto();
    });

    $("#producto_cantidad").on('input', function() {
        calcular_totales_producto();
    }).on('change', function() {
        calcular_totales_producto();
    });

    $("#producto_total").on('input', function() {
        calcular_totales_producto_2();
    }).on('change', function() {
        calcular_totales_producto_2();
    });

    $(".btn_agregarproducto_detalle").click(add_to_detalle);
    $(".clickable-row").click(function() {
        console.log("ada");
    });
    $("#frm_producto").submit(function(e) {
        e.preventDefault();
        add_to_detalle();
        $('#producto_subtotal').val(0);
        $('#producto_cantidad').val(0);
        $('#producto_total').val(0);
        $('#producto_cantidad').attr('readonly', true);
        $('#producto_preciounidad').attr('readonly', true);
    });
    $("#frm_producto_outside").submit(function(e) {
        e.preventDefault();
        add_to_detalle2();
    });
    $("#frm_servicio").submit(function(e) {
        e.preventDefault();
        add_to_detalle_servicio();
    });
    $(".btn_eliminarproducto").click(eliminar_producto_detalle);
});

function eliminar(e) {
    $("#" + e).remove();
    calcular_totales_documento();

}

function add_to_detalle() {
    var textoReferencial = $('#producto_descripcionExtra').val();
    var idarticulo = $('#producto_codigo').val();
    var grid = jQuery("#detalle_documento");
    var ids = grid.jqGrid('getDataIDs');

    //alert(idarticulo);
    for (var i = 0; i < ids.length; i++) {
        var id = ids[i];
        if (id == idarticulo) {
            alert("No es posible añadir dos veces el mismo producto");
            return;
        }
    }
    var x = "'" + idarticulo + "'";
    $('#detalle_documento > tbody:last-child').append('<tr role="row" ondblclick="eliminar(' + x + ')" id="' + idarticulo + '" tabindex="-1" class="jqgrow ui-row-ltr ui-widget-content">' +
        '<td role="gridcell" style="display:none;" title="' + idarticulo + '" aria-describedby="detalle_documento_idarticulo">' + idarticulo + '</td>' +
        '<td role="gridcell" title="' + idarticulo + '" aria-describedby="detalle_documento_codigo">' + idarticulo + '</td>' +
        '<td role="gridcell" title="' + $('#producto_descripcion option:selected').text().trim() + '" aria-describedby="detalle_documento_descripcion">' + $('#producto_descripcion option:selected').text().trim() + '</td>' +
        '<td role="gridcell" style="display:none;" title="' + $('#producto_unidadmedida').val() + '" aria-describedby="detalle_documento_idunidadmedida">' + $('#producto_unidadmedida').val() + '</td>' +
        '<td role="gridcell" title="' + $('#producto_unidadmedida').val() + '" aria-describedby="detalle_documento_unidadmedida">' + $('#producto_unidadmedida').val() + '</td>' +
        '<td role="gridcell" style="display:none;" title="' + textoReferencial + '" >' + textoReferencial + '</td>' +
        '<td role="gridcell" style="text-align:right;" title="' + $('#producto_preciounidad').val() + '" aria-describedby="detalle_documento_precio">' + $('#producto_preciounidad').val() + '</td>' +
        '<td role="gridcell" style="text-align:right;" title="' + $('#producto_cantidad').val() + '" aria-describedby="detalle_documento_cantidad">' + $('#producto_cantidad').val() + '</td>' +
        '<td role="gridcell" style="text-align:right;" title="' + $('#producto_subtotal').val() + '" aria-describedby="detalle_documento_subtotal">' + $('#producto_subtotal').val() + '</td>' +
        '<td role="gridcell" style="text-align:right;" title="' + $('#producto_igv').val() + '" aria-describedby="detalle_documento_igv">' + $('#producto_igv').val() + '</td>' +
        '<td role="gridcell" style="text-align:left;" title="' + $('#producto_total').val() + '" aria-describedby="detalle_documento_importe">' + $('#producto_total').val() + '</td>' +
        '<td role="gridcell" style="display:none;" title="V" aria-describedby="detalle_documento_estado">V</td>' +
        '</tr>');
    calcular_totales_documento();
    $("#vm_agregar_articulo").modal("hide");
}

function add_to_detalle_producto(productos) {

    var textoReferencial = $('#producto_descripcionExtra').val();
    var idarticulo = $('#producto_codigo').val();
    var x = "'" + idarticulo + "'";

    let html = '';

    for (let i = 0; i < productos.length; i++) {
        let importe = (parseFloat(productos[i].montoproducto) + parseFloat(productos[i].montoproducto * .18));
        html += `
            <tr role="row" ondblclick="eliminar(${productos[i].producto_id})" id="${productos[i].producto_id}" tabindex="-1" class="jqgrow ui-row-ltr ui-widget-content">
                <td role="gridcell" style="display:none;" title="${productos[i].producto_id}" aria-describedby="detalle_documento_idarticulo">${productos[i].producto_id}</td>
                <td role="gridcell" title="${productos[i].producto_id}" aria-describedby="detalle_documento_codigo">${productos[i].producto_id}</td>
                <td role="gridcell" title="${productos[i].nombre_producto}" aria-describedby="detalle_documento_descripcion">${productos[i].nombre_producto}</td>
                <td role="gridcell" style="display:none;" title="UNIDAD" aria-describedby="detalle_documento_idunidadmedida">UNIDAD</td>
                <td role="gridcell" title="UNIDAD" aria-describedby="detalle_documento_unidadmedida">UNIDAD</td>
                <td role="gridcell" style="display:none;" title="textoReferencial" >textoReferencial</td>
                <td role="gridcell" style="text-align:right;" title="${productos[i].precioproducto}" aria-describedby="detalle_documento_precio">${productos[i].precioproducto}</td>
                <td role="gridcell" style="text-align:right;" title="${productos[i].cantidad}" aria-describedby="detalle_documento_cantidad">${productos[i].cantidad}</td>
                <td role="gridcell" style="text-align:right;" title="${parseFloat(productos[i].montoproducto).toFixed(1)}" aria-describedby="detalle_documento_subtotal">${parseFloat(productos[i].montoproducto).toFixed(1)}</td>
                <td role="gridcell" style="text-align:right;" title="${parseFloat(productos[i].montoproducto * .18).toFixed(1)}" aria-describedby="detalle_documento_igv">${parseFloat(productos[i].montoproducto * .18).toFixed(1)}</td>
                <td role="gridcell" style="text-align:right;" title="${parseFloat(importe).toFixed(1)}" aria-describedby="detalle_documento_importe">${parseFloat(importe).toFixed(1)}</td>
                <td role="gridcell" style="display:none;" title="V" aria-describedby="detalle_documento_estado">V</td>
            </tr>
        `;
    } //end for i

    $('#detalle_documento > tbody:last-child').append(html);
    calcular_totales_documento();
}

function add_to_detalle2() {
    var permiso = 1;
    $(".ps").each(function() {
        if ($('#producto_serie_id').val() == $(this).html()) {
            alert("Esta serie ya fue seleccionada, por favor elija otra.");
            permiso = 0;
        }
    });
    if (permiso == 1) {
        var idarticulo = $('#producto_serie_id').val();

        var x = "'" + idarticulo + "'";
        $('#detalle_documento > tbody:last-child').append('<tr role="row" ondblclick="eliminar(' + x + ')" id="' + idarticulo + '" tabindex="-1" class="jqgrow ui-row-ltr ui-widget-content">' +
            '<td role="gridcell" style="display:none;" title="' + idarticulo + '" aria-describedby="detalle_documento_idarticulo">' + idarticulo + '</td>' +
            '<td role="gridcell" style="" title="' + idarticulo + '" aria-describedby="detalle_documento_codigo">' + idarticulo + '</td>' +
            '<td role="gridcell" style="" title="' + $('#producto_descripcion2 option:selected').text().trim() + '" aria-describedby="detalle_documento_descripcion">' + $('#producto_descripcion2 option:selected').text().trim() + '</td>' +
            '<td role="gridcell" style="display:none;" title="' + $('#producto_unidadmedida2').val() + '" aria-describedby="detalle_documento_idunidadmedida">' + $('#producto_unidadmedida2').val() + '</td>' +
            '<td role="gridcell" style="" title="' + $('#producto_unidadmedida2').val() + '" aria-describedby="detalle_documento_unidadmedida">' + $('#producto_unidadmedida2').val() + '</td>' +
            '<td role="gridcell" style="display:none;" class="ps" title="' + $('#producto_serie_id2').val() + '" aria-describedby="detalle_documento_productoserieid">' + $('#producto_serie_id2').val() + '</td>' +
            '<td role="gridcell" style="display:none;" class="s" title="' + idarticulo + '" aria-describedby="detalle_documento_servicioid">' + idarticulo + '</td>' +
            '<td role="gridcell" title="' + $('#producto_serie_id option:selected2').text().trim() + '" aria-describedby="detalle_documento_serie">' + $('#producto_serie_id option2:selected').text().trim() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#producto_preciounidad2').val() + '" aria-describedby="detalle_documento_precio">' + $('#producto_preciounidad2').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#producto_cantidad2').val() + '" aria-describedby="detalle_documento_cantidad">' + $('#producto_cantidad2').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#producto_subtotal2').val() + '" aria-describedby="detalle_documento_subtotal">' + $('#producto_subtotal2').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#producto_igv2').val() + '" aria-describedby="detalle_documento_igv">' + $('#producto_igv2').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#producto_total2').val() + '" aria-describedby="detalle_documento_importe">' + $('#producto_total2').val() + '</td>' +
            '<td role="gridcell" style="display:none;" title="V" aria-describedby="detalle_documento_estado">V</td>' +
            '</tr>');
        calcular_totales_documento();
        $('#producto_serie_id2')
            .find('option')
            .remove()
            .end()
            .append('<option value="">(SELECCIONAR)</option>')
            .val('whatever');
        $('#producto_descripcion option[value=""]').prop('selected', 'selected').change();
        $("#vm_agregar_articulo").modal("hide");
    }
}

function add_to_detalle_servicio() {
    var permiso = 1;
    $(".s").each(function() {
        if ($('#servicio_descripcion').val() == $(this).html()) {
            alert("Esta serie ya fue seleccionada, por favor elija otra.");
            permiso = 0;
        }
    });
    if (permiso == 1) {
        var idarticulo = "-";
        var x = "'" + idarticulo + "'";
        $('#detalle_documento > tbody:last-child').append('<tr role="row" ondblclick="eliminar(' + x + ')" id="' + idarticulo + '" tabindex="-1" class="jqgrow ui-row-ltr ui-widget-content">' +
            '<td role="gridcell" style="display:none;" title="' + $('#servicio_descripcion').val() + '" aria-describedby="detalle_documento_idarticulo">' + $('#servicio_descripcion').val() + '</td>' +
            '<td role="gridcell" style="" title="' + idarticulo + '" aria-describedby="detalle_documento_codigo">' + idarticulo + '</td>' +
            '<td role="gridcell" style="" title="' + $('#servicio_descripcion').val() + '" aria-describedby="detalle_documento_descripcion">' + $('#servicio_descripcion').val() + '</td>' +
            '<td role="gridcell" style="display:none;" title="' + $('#servicio_unidadmedida').val() + '" aria-describedby="detalle_documento_idunidadmedida">' + $('#servicio_unidadmedida').val() + '</td>' +
            '<td role="gridcell" style="" title="' + $('#servicio_unidadmedida').val() + '" aria-describedby="detalle_documento_unidadmedida">' + $('#servicio_unidadmedida').val() + '</td>' +
            '<td role="gridcell" style="display:none;" class="s" title="' + $('#servicio_descripcion').val() + '" aria-describedby="detalle_documento_servicioid">' + $('#servicio_descripcion').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#servicio_preciounidad').val() + '" aria-describedby="detalle_documento_precio">' + $('#servicio_preciounidad').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#servicio_cantidad').val() + '" aria-describedby="detalle_documento_cantidad">' + $('#servicio_cantidad').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#servicio_subtotal').val() + '" aria-describedby="detalle_documento_subtotal">' + $('#servicio_subtotal').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#servicio_igv').val() + '" aria-describedby="detalle_documento_igv">' + $('#servicio_igv').val() + '</td>' +
            '<td role="gridcell" style="text-align:right;" title="' + $('#servicio_total').val() + '" aria-describedby="detalle_documento_importe">' + $('#servicio_total').val() + '</td>' +
            '<td role="gridcell" style="display:none;" title="V" aria-describedby="detalle_documento_estado">V</td>' +
            '</tr>');
        calcular_totales_documento();
        $('#servicio_descripcion option[value=""]').prop('selected', 'selected').change();
        $("#vm_agregar_servicio").modal("hide");
    }
}

function calcular_totales_producto_2() {
    var igv_percent = parseFloat((18 / 100) + 1);
    var precioarticulo = 0;
    var total = 0;

    if ($('#producto_preciounidad').val() == '' || $('#producto_preciounidad').val() <= 0 || isNaN($('#producto_preciounidad').val())) {
        precioarticulo = 0;
    } else {
        precioarticulo = parseFloat($('#producto_preciounidad').val());
    }

    if ($('#producto_total').val() == '' || $('#producto_total').val() <= 0 || isNaN($('#producto_total').val())) {
        total = 0;
    } else {
        total = parseFloat($('#producto_total').val());
    }

    var cantidad = round_math(parseFloat(total) / parseFloat(precioarticulo), 3);
    var subtotal = parseFloat(total) / parseFloat(igv_percent);
    var igv = parseFloat(total) - parseFloat(subtotal);

    $('#producto_subtotal').val(round_math(subtotal, 2));
    $('#producto_igv').val(round_math(igv, 2));
    $('#producto_cantidad').val(round_math(cantidad, 3));
}

function calcular_totales_producto() {
    var igv_percent = parseFloat((18 / 100) + 1);
    var precioarticulo = 0;
    var cantidad = 0;

    if ($('#producto_preciounidad').val() == '' || $('#producto_preciounidad').val() <= 0 || isNaN($('#producto_preciounidad').val())) {
        precioarticulo = 0;
    } else {
        precioarticulo = parseFloat($('#producto_preciounidad').val());
    }

    if ($('#producto_cantidad').val() == '' || $('#producto_cantidad').val() <= 0 || isNaN($('#producto_cantidad').val())) {
        cantidad = 0;
    } else {
        cantidad = parseFloat($('#producto_cantidad').val());
    }

    var total = round_math(parseFloat(precioarticulo) * parseFloat(cantidad), 2);
    var subtotal = parseFloat(total) / parseFloat(igv_percent);
    var igv = parseFloat(total) - parseFloat(subtotal);

    $('#producto_subtotal').val(round_math(subtotal, 2));
    $('#producto_igv').val(round_math(igv, 2));
    $('#producto_total').val(round_math(total, 2));
}

function calcular_totales_servicio() {
    var igv_percent = parseFloat((18 / 100) + 1);
    var precioarticulo = 0;
    var cantidad = 0;

    if ($('#servicio_preciounidad').val() == '' || $('#servicio_preciounidad').val() <= 0 || isNaN($('#servicio_preciounidad').val())) {
        precioarticulo = 0;
    } else {
        precioarticulo = parseFloat($('#servicio_preciounidad').val());
    }

    if ($('#servicio_cantidad').val() == '' || $('#servicio_cantidad').val() <= 0 || isNaN($('#servicio_cantidad').val())) {
        cantidad = 0;
    } else {
        cantidad = parseFloat($('#servicio_cantidad').val());
    }

    var total = round_math(parseFloat(precioarticulo) * parseFloat(cantidad), 2);
    var subtotal = parseFloat(total) / parseFloat(igv_percent);
    var igv = parseFloat(total) - parseFloat(subtotal);

    $('#servicio_subtotal').val(round_math(subtotal, 2));
    $('#servicio_igv').val(round_math(igv, 2));
    $('#servicio_total').val(round_math(total, 2));
}

function calcular_totales_documento() {
    var sub_total = 0;
    var igv = 0;
    var importe = 0;
    var grid = jQuery("#detalle_documento");
    var ids = grid.jqGrid('getDataIDs');
    for (var i = 0; i < ids.length; i++) {
        var id = ids[i];
        console.log(grid.jqGrid('getCell', id, 'subtotal'));
        sub_total = parseFloat(sub_total) + parseFloat(grid.jqGrid('getCell', id, 'subtotal'));
        igv = parseFloat(igv) + parseFloat(grid.jqGrid('getCell', id, 'igv'));
        importe = parseFloat(importe) + parseFloat(grid.jqGrid('getCell', id, 'importe'));
    }
    $("#subtotal_documento").html(round_math(sub_total, 2));
    $("#txt_subtotal_comprobante").val(round_math(sub_total, 2));
    $("#igv_documento").html(round_math(igv, 2));
    $("#txt_igv_comprobante").val(round_math(igv, 2));
    $("#total_documento").html(round_math(importe, 2));
    $("#txt_total_comprobante").val(round_math(importe, 2));
    var numletras = NumeroALetras(importe);
    $("#txt_total_letras").val(numletras);
    // Mostrar y ocultar el boton de GUARDAR DOCUMENTO ELECTRONICO
    if (round_math(importe, 2) > 0) {
        $('#btn_guardar_doc_electronic').show();
    } else {
        $('#btn_guardar_doc_electronic').hide();
    }
}

function eliminar_producto_detalle() {
    var rowid = jQuery('#detalle_documento').jqGrid('getGridParam', 'selrow');
    var $grid = jQuery("#detalle_documento");
    $grid.jqGrid('delRowData', rowid);
    calcular_totales_documento();
}

function round_math(numero, decimales) {
    var flotante = parseFloat(numero);
    var resultado = Math.round(flotante * Math.pow(10, decimales)) / Math.pow(10, decimales);
    return resultado;
}

function search_document() {

    $("#icon_search_document").hide();
    $("#icon_searching_document").show();
    $(".search_document").prop('disabled', true);

    var tipodoc = $("#cliente_tipodocumento").val().toString();
    var numdoc = $("#cliente_numerodocumento").val();
    if (tipodoc == '6') { //RUC
        /*var resp = validar_numero_ruc(numdoc);
        if(resp == 1) {
            consultar_ruc(numdoc);
        }*/
        consultar_ruc(numdoc);
    } else if (tipodoc == '1') { //DNI
        consultar_dni(numdoc);
    } else {

    }

}

function consultar_dni(dni) {

    $("#cliente_nombre").val("CLIENTES VARIOS");
    $("#cliente_direccion").val("-");
    $("#cliente_numerodocumento").val("00000000");
    $("#icon_search_document").show();
    $("#icon_searching_document").hide();
    $(".search_document").prop('disabled', false);
    /* $.ajax({
      
        url : 'https://cors-anywhere.herokuapp.com/https://sistemadefacturacionelectronicasunat.com/sis_facturacion/controllers/busquedas.php',
         data: {num_documento: dni, tipo: 'dni'},
        method :  'POST',
        dataType : "json"




    }).then(function(data){
        if(data.respuesta == 'ok') {
            $("#cliente_nombre").val(data.nombre);
        } else {
            $("#cliente_nombre").val(data.mensaje);
        }
        $("#icon_search_document").show();
        $("#icon_searching_document").hide();
        $(".search_document").prop('disabled', false);

        

    }, function(reason){
        swal({
            title: 'ERROR',
            text: 'Error al conectarse a la SUNAT, recarga la página e inténtalo nuevamente!',
            html: true,
            type: "error",
            confirmButtonText: "Ok",
            confirmButtonColor: "#2196F3"
        }, function(){
            $("#icon_search_document").show();
            $("#icon_searching_document").hide();
            $(".search_document").prop('disabled', false);
        });
    }); */
}

function consultar_ruc(ruc) {

    $.ajax({
        url: 'https://cors-anywhere.herokuapp.com/http://apologrupo.com/sunat/index.php/Welcome/ruc/' + ruc,
        data: { ruc: ruc, token: "31e2ad8" },
        method: 'GET',
        dataType: "json"
    }).then(function(data) {
        $("#icon_search_document").show();
        $("#icon_searching_document").hide();
        $(".search_document").prop('disabled', false);

        $("#cliente_nombre").val(data.Bk_RucRazonSocial);
        $("#cliente_direccion").val(data.Direccion);
        console.log(data);

    }, function(reason) {
        swal({
            title: 'ERROR',
            text: 'Error al conectarse a la SUNAT, recarga la página e inténtalo nuevamente!',
            html: true,
            type: "error",
            confirmButtonText: "Ok",
            confirmButtonColor: "#2196F3"
        }, function() {
            $("#icon_search_document").show();
            $("#icon_searching_document").hide();
            $(".search_document").prop('disabled', false);
        });
    });
}

function inicializar_tabla_detalle() {
    $.jgrid.no_legacy_api = true;
    $.jgrid.useJSON = true;
    var detalle_documento = $('#detalle_documento');
    detalle_documento = detalle_documento.jqGrid({
        url: '',
        datatype: 'json',
        mtype: 'POST',
        colNames: [
            'idarticulo',
            'Codigo',
            'Descripcion',
            'idunidadmedida',
            'Und/Medida',
            'texto_referencial',
            'Precio',
            'Cantidad',
            'Sub.Total',
            'Igv',
            'Importe',
            'Estado'
        ],
        colModel: [
            { name: 'idarticulo', index: '1', hidden: true },
            { name: 'codigo', index: '2', width: 90 },
            { name: 'descripcion', index: '3', width: 100 },
            { name: 'idunidadmedida', index: '4', hidden: true },
            { name: 'unidadmedida', index: '5', width: 100 },
            { name: 'texto_referencial', index: '6', hidden: true },
            { name: 'precio', index: '7', width: 80, align: "right" },
            { name: 'cantidad', index: '8', width: 80, align: "right" },
            { name: 'subtotal', index: '9', width: 85, align: "right" },
            { name: 'igv', index: '10', width: 60, align: "right" },
            { name: 'importe', index: '11', width: 90, align: "right" },
            { name: 'estado', index: '12', hidden: true }
        ],
        height: 100,
        shrinkToFit: false,
        rowNum: 0,
        loadOnce: true,
        viewrecords: true,
        gridview: true,
        cellEdit: true,
        sortname: 'codigo',
        cellsubmit: 'clientArray',
        editurl: 'clientArray',
        beforeRequest: function() {
            responsive_table($(".jqGrid"));
        },
        jsonReader: {
            repeatitems: false,
            root: 'lstLista'
        }
    });
}

function responsive_table(table) {
    table.find('.ui-jqgrid').addClass('clear-margin span12').css('width', '');
    table.find('.ui-jqgrid-view').addClass('clear-margin span12').css('width', '');
    table.find('.ui-jqgrid-view > div').eq(1).addClass('clear-margin span12').css('width', '').css('min-height', '0');
    table.find('.ui-jqgrid-view > div').eq(2).addClass('clear-margin span12').css('width', '').css('min-height', '0');
    table.find('.ui-jqgrid-sdiv').addClass('clear-margin span12').css('width', '');
    table.find('.ui-jqgrid-pager').addClass('clear-margin span12').css('width', '');
}

function inicializar_controles() {

    $('.stepy-step').find('.button-next').addClass('btn btn-primary');
    $('.stepy-step').find('.button-back').addClass('btn btn-default');

    // Primary
    $(".control-primary").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-primary-600 text-primary-800'
    });

    // Danger
    $(".control-danger").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-danger-600 text-danger-800'
    });

    // Success
    $(".control-success").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-success-600 text-success-800'
    });

    // Warning
    $(".control-warning").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-warning-600 text-warning-800'
    });

    // Info
    $(".control-info").uniform({
        radioClass: 'choice',
        wrapperClass: 'border-info-600 text-info-800'
    });

}

function validar_numero_ruc(numruc) {
    var regEx = /\d{11}/;

    var ruc = new String(numruc);

    if (ruc.length != 11) {
        swal({
            title: 'ERROR',
            text: 'El RUC: ' + numruc + ' es Inválido.',
            html: true,
            type: "error",
            confirmButtonText: "Ok",
            confirmButtonColor: "#2196F3"
        }, function() {
            $("#icon_search_document").show();
            $("#icon_searching_document").hide();
            $(".search_document").prop('disabled', false);
        });
        return 0;
    }

    if (regEx.test(ruc)) {
        var factores = new String("5432765432");
        var ultimoIndex = ruc.length - 1;
        var sumaTotal = 0,
            residuo = 0;
        var ultimoDigitoRUC = 0,
            ultimoDigitoCalc = 0;

        for (var i = 0; i < ultimoIndex; i++) {
            sumaTotal += (parseInt(ruc.charAt(i)) * parseInt(factores.charAt(i)));
        }
        residuo = sumaTotal % 11;

        ultimoDigitoCalc = (residuo == 10) ? 0 : ((residuo == 11) ? 1 : (11 - residuo) % 10);
        ultimoDigitoRUC = parseInt(ruc.charAt(ultimoIndex));

        if (ultimoDigitoRUC == ultimoDigitoCalc) {
            //alert("¡El RUC " + ruc + " SÍ es válido!.");
            return 1;
        } else {
            swal({
                title: 'ERROR',
                text: 'El RUC: ' + numruc + ' es Inválido.',
                html: true,
                type: "error",
                confirmButtonText: "Ok",
                confirmButtonColor: "#2196F3"
            }, function() {
                $("#icon_search_document").show();
                $("#icon_searching_document").hide();
                $(".search_document").prop('disabled', false);
            });
            return 0;
        }
    } else {
        swal({
            title: 'ERROR',
            text: 'El RUC debe constar de 11 caracteres numéricos. Si no tiene RUC, por favor selecciona BOLETA.',
            html: true,
            type: "error",
            confirmButtonText: "Ok",
            confirmButtonColor: "#2196F3"
        }, function() {
            $("#icon_search_document").show();
            $("#icon_searching_document").hide();
            $(".search_document").prop('disabled', false);
        });
        $("#cliente_numerodocumento").focus();
        return 0;
    }

    return 1;
}