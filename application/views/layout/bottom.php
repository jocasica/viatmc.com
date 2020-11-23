<div class="modal fade" id="modal_cpe" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Facturación Electrónica</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>
</div>
<script src="<?= base_url() ?>panel/assets/libs/jquery/dist/jquery.min.js"></script>
<script src="<?= base_url() ?>panel/assets/libs/popper.js/dist/umd/popper.min.js"></script>
<script src="<?= base_url() ?>panel/assets/libs/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="<?= base_url() ?>panel/dist/js/app-style-switcher.js"></script>
<script src="<?= base_url() ?>panel/dist/js/waves.js"></script>
<script src="<?= base_url() ?>panel/dist/js/sidebarmenu.js"></script>
<script src="<?= base_url() ?>panel/dist/js/custom.js"></script>
<script type="text/javascript" src="<?= base_url('') ?>plantilla/assets/js/plugins/forms/selects/select2.min.js"></script>
<script src="<?= base_url() ?>panel/assets/libs/chartist/dist/chartist.min.js"></script>
<script src="<?= base_url() ?>panel/assets/libs/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js"></script>
<script src="<?= base_url() ?>js/jquery.redirect.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.15/dist/summernote.min.js"></script>
<!-- Datatables -->
<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
<script src="<?= base_url() ?>js/block-ui.js"></script>
<!-- DataTable Export -->
<script src="https://cdn.datatables.net/buttons/1.5.1/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.html5.min.js"></script>
<script type="text/javascript">
    function mostrarModalImagen(element) {
        var name = $(element).attr('data-name');
        var image = $(element).attr('data-image');

        $('#titleProductName').html(name);
        $("#imagenModalProducto").attr('src', image);
        //console.log(image);
        $("#mostrarImagen").modal('show');
    }
    var updating = false;
    var deletedSeriesIds = [];

    var spanishTableInfo = {
        "sProcessing": "Procesando...",
        "sLengthMenu": "Mostrar _MENU_ registros",
        "sZeroRecords": "No se encontraron resultados",
        "sEmptyTable": "Ningún dato disponible en esta tabla",
        "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
        "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
        "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
        "sInfoPostFix": "",
        "sSearch": "Buscar:",
        "sUrl": "",
        "sInfoThousands": ",",
        "sLoadingRecords": "Cargando...",
        "oPaginate": {
            "sFirst": "Primero",
            "sLast": "Último",
            "sNext": "Siguiente",
            "sPrevious": "Anterior"
        },
        "oAria": {
            "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
            "sSortDescending": ": Activar para ordenar la columna de manera descendente"
        },
        "buttons": {
            "copy": "Copiar",
            "colvis": "Visibilidad"
        }
    };

    var seaceTable = null;
    var customData = {};
    jQuery(function($) {
        $('#vm_add_producto').on('hidden.bs.modal', function() {
            $('#frm-add-producto').trigger("reset");
            $('#frm-add-producto img').attr('src', '');
        });

        $('#PrincipalSectionTable').DataTable({
            language: spanishTableInfo,
            "order": [[ 1, "desc" ]]
        });
        $('#PrincipalSectionTableAnuladas').DataTable({
            language: spanishTableInfo
        });
        $('#PrincipalSectionTableAnuladasBoletas').DataTable({
            language: spanishTableInfo
        });
        
        $('#tabla_lista_guias_remision').DataTable({
            language: spanishTableInfo,
            "order": [[ 2, "desc" ]],
            "scrollX": true
            //"order": false // por orden de fecha de remisión
        });

        $('#tabla_principal_notas_credito').DataTable({
            language: spanishTableInfo,"order": [[ 1, "desc" ]]
        });

        seaceTable = $('#seaceTable').DataTable({
            language: spanishTableInfo,
            data: customData
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#placeholderImage').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]); // convert to base64 string
            }
        }

        $("#imgInp").change(function() {
            readURL(this);
        });

        $('#reporte-formulario').submit(function(event) {
            event.preventDefault();
            $.ajax({
                url: 'reporte',
                type: 'POST',
                dataType: 'text',
                data: $(this).serialize(),
                success: function(request) {
                    let obj = JSON.parse(request);
                    customData = obj;
                    seaceTable.clear();
                    seaceTable.rows.add(customData).draw();
                },
                error: function(request, error) {
                    alert("AJAX Call Error: " + error);
                }
            });
        });

        $('#productos-table').DataTable({});
        $('.select2').select2();

        $('#summernote').summernote({
            lineHeights: ['0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1', '0.1']
            //                 toolbar: [
            //     // [groupName, [list of button]]
            //     ['style', ['bold', 'italic', 'underline']],

            //     ['fontsize', ['fontsize']],
            //     ['color', ['color']],
            //     ['para', ['ul', 'ol', 'paragraph']],
            //     ['height', ['height']]
            //   ]
        });

        $('#btn-dbf').on('click', function(e) {
            var mes = $("#mes_concar").val();
            var ano = $("#ano_concar").val();
            var doc = $("#doc_concar").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=dbf&id=1&mes=" + mes + "&ano=" + ano + "&doc=" + doc, "_blank");
        });
        var allow = false;

        // $('#frm-cot-serv').on('submit',function(e){
        //     var r = $('#table_compra tr').length;
        //     var series = $('#frm-cot-serv').serialize();
        //     series = series + "&codedata="+$('#summernote').summernote('code')
        //     e.preventDefault();
        //         $.ajax({
        //             url : '<?= base_url('producto/postservicio') ?>',
        //             method :  'POST',
        //             dataType : "json",
        //             data: series
        //         });
        // });

        var allowSubmit = false;
        $('#frm-producto').on('submit', function(e) {
            if (!allowSubmit) {
                e.preventDefault();
                // $.ajax({
                //     url : '<?= base_url('producto/verificar_cod_barra') ?>',
                //     method :  'POST',
                //     dataType : "json",
                //     data: {codigo_barra : $('#serie').val().trim()}
                // }).then(function(data){
                //     if (Number(data) > 0) {
                //         alert("El codigo de barras ya ha sido registrado.");
                //     }
                //     else{
                //         $('#frm-producto').submit();
                //     }
                // }, function(reason){
                //     console.log(reason);
                // });

                allowSubmit = true;
            }
        });

        $('#btn-documentos-reporte').on('click', function(e) {
            var mes = $("#mes_report").val();
            var ano = $("#ano_report").val();
            var doc = $("#doc_report").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=documentos&id=1&mes=" + mes + "&ano=" + ano +
                "&doc=" + doc, "_blank");
        });

        $('#btn-comprobantes-reporte').on('click', function(e) {
            var date1 = $("#date1").val();
            var date2 = $("#date2").val();
            var doc = $("#doc_report").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=comprobantes&id=1&date1=" + date1 + "&date2=" + date2 +
                "&doc=" + doc, "_blank");
        });

        $('#btn-venta-reporte-venta').on('click', function(e) {
            var date = $("#date_venta").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=reporteventa&id=1&date=" + date, "_blank");
        });

        $('#btn-venta-productos-reporte').on('click', function(e) {
            var mes = $("#mes_report").val();
            var ano = $("#ano_report").val();
            var product = $("#product_report").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=venta_productos&id=1&mes=" + mes + "&ano=" + ano +
                "&product=" + product, "_blank");
        });

        $('#btn-compra-productos-reporte').on('click', function(e) {
            var mes = $("#mes_report").val();
            var ano = $("#ano_report").val();
            var product = $("#product_report").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=compra_productos&id=1&mes=" + mes + "&ano=" + ano +
                "&product=" + product, "_blank");
        });

        $(document).on("click", ".a-correo", function() {
            $(".modal-body #serie").val($(this).data('serie'));
            $(".modal-body #numero").val($(this).data('numero'));
            $(".modal-body #venta_id").val($(this).data('venta_id'));
            $(".modal-body #comprobante").val($(this).attr('data-serie') + " - " + $(this).attr('data-numero'));
        });
        $('#btn-kardex').on('click', function(e) {
            var id = $("#producto_kardex").val();
            var mes = $("#mes_kardex").val();
            var ano = $("#ano_kardex").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=kardex&id=" + id + "&mes=" + mes + "&ano=" + ano, "_blank");
        });
        $('#btn-kardex-excel').on('click', function(e) {
            var id = $("#producto_kardex").val();
            var mes = $("#mes_kardex").val();
            var ano = $("#ano_kardex").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=kardex_excel&id=" + id + "&mes=" + mes + "&ano=" + ano, "_blank");
        });
        $('#btn-venta-reporte').on('click', function(e) {
            var mes = $("#mes_concar").val();
            var ano = $("#ano_concar").val();
            var doc = $("#doc_concar").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=venta&id=1&mes=" + mes + "&ano=" + ano + "&doc=" + doc, "_blank");
        });
        $('#btn-concar').on('click', function(e) {
            var mes = $("#mes_concar").val();
            var ano = $("#ano_concar").val();
            var doc = $("#doc_concar").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=concar&id=1&mes=" + mes + "&ano=" + ano + "&doc=" + doc, "_blank");
        });
        $('#table_compra').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            var i = 1;
            $('#table_compra  > tr').each(function() {
                $(this).find(".n").text(i);
                i++;
            });
        });

        $('#tbody_producto_remision').on('click', '.edit', function(e) {
            updating = true;

            e.preventDefault();
            var dataRow = $(this).closest('tr').attr('data-product');
            var dataProductId = $(this).closest('tr').attr('data-product-id');

            dataRow = JSON.parse(dataRow);
            dataRow.forEach((el, key) => {
                $('#vm_add_producto ' + '#' + el.name).val(el.value);
            });

            $("#vm_add_producto #productId").val(dataProductId);
            $("#vm_add_producto button[type=submit]").html("Actualizar");
            $('#vm_add_producto').modal('show');
        });

        $('#myModal').on('hidden.bs.modal', function() {
            $("#vm_add_producto button[type=submit]").html("Agregar");
            $("#vm_add_producto #productId").val(0);
        });

        $('#frms').on('submit', function(e) {
            e.preventDefault();
            console.log($(this).serialize());
        });
        $('#moneda').on('change', function(e) {
            if ($(this).val() == "DOLARES") {
                $("#div_tipo_cambio").prop("hidden", false);
            } else {
                $("#tipocambio").val(null);
                $("#div_tipo_cambio").prop("hidden", true);
            }
        });
        function addSerie(quantity) {
            var series = $("#customSeries > div").length;
            for (var i = 0; i < quantity; i++) {
                var currentItem = 0;
                if (series === 0) {
                        currentItem = i;
                } else {
                        currentItem = series;
                }

                var serie = '<div class="form-group row serieItem" style="padding-left: 10px"> ' +
                        '<label class="col-sm-2 col-form-label col-form-label" style="background: #F2F2F2">#' + ((currentItem + 1) + "").padStart(2, "0") + ' Serie: </label> ' +
                        '<div class="col-sm-9"> <input type="text" name="serie[]" class="form-control" required> </div> ' + '<div class="col-sm-1"> <span class="close-btn">x</span> </div>'
                '</div>';

                $("#customSeries").append(serie)
            }

            $('#customSeries .close-btn').on('click', function(e) {
                    e.preventDefault();
                    $(this).closest('.serieItem').remove();
                    $('#cantidad').val($("#customSeries > div").length);
            })
        }

        function removeSerie(quantity) {
            for (var i = 0; i < quantity; i++) {
                var series = $("#customSeries > div");
                series.eq(series.length - 1).remove();
            }

            $('#cantidad').val($("#customSeries > div").length);
        }

	function addSeries() {
        var quantity = $('#cantidad').val();
        var currentLength = $("#customSeries > div").length;

        if (currentLength === 0) {
            addSerie(quantity)
        } else {
            if (quantity === currentLength) {} else if (quantity < currentLength) {
                removeSerie(currentLength - quantity);
            } else if (quantity > currentLength) {
                addSerie(quantity - currentLength)
            }
        }
    }

	$("input[name='trabajarConSeries']").on('change', function() {
					validateChanges(this.value);
			});

			function validateChanges(value) {
					if (value > 0) {
							$("#trabajarConSeries").removeClass('hide');
							addSeries();
					} else {
							$("#trabajarConSeries").addClass('hide');
							$("#customSeries").html('');
					}
			}

        $('#customSeries .close-btn').on('click', function(e) {
            e.preventDefault();
            var dataId = $(this).closest('.serieItem').find('input[type=text]').attr('data-id');
            if (dataId !== null || dataId !== undefined) {
                deletedSeriesIds.push(dataId);
            }

            $('#deletedSeries').val(deletedSeriesIds.join(','));
            $(this).closest('.serieItem').remove();
            $('#cantidad').val($("#customSeries > div").length);
        })

        
        $('#frm-correo').on('submit', function(e) {
            e.preventDefault();
            var obj = new Object();
            obj.serie = $('#serie').val();
            obj.numero = $('#numero').val();
            obj.correo = $('#correo').val();
            obj.venta_id = $('#venta_id').val();
            $.ajax({
                url: '<?= base_url('venta/enviar') ?>',
                method: 'POST',
                dataType: "json",
                data: obj
            }).then(function(data) {
                console.log(data);
                if (Number(data) > 0) {
                    alert("Correo enviado exitosamente.");
                    $('#vm_enviar_correo').modal('hide');
                } else {
                    alert("Error al enviar el correo.");
                }
            }, function(reason) {
                console.log(reason);
            });
        });
        $(".ver-productos").on('click', function() {
            $("#body_tbl > tbody").empty();
            var obj = new Object();
            obj.compra_id = $(this).attr("compra_id");
            $.ajax({
                url: '<?= base_url('compra/obtener_productos_compra') ?>',
                method: 'POST',
                dataType: "json",
                data: obj
            }).then(function(data) {
                data.forEach(function(cp, index) {
                    if (cp.estado == 1) {
                        $('#body_tbl > tbody:last-child').append('<tr>' +
                            '<td>' + cp.id + '</td>' +
                            '<td>' + cp.proveedor + '</td>' +
                            '<td><h4 class="m-b-0 font-16">' + cp.nombre + '</h4></td>' +
                            '<td>' + cp.serie + '</td>' +
                            '<td>' + cp.garantia + '</td>' +
                            '<td align="right">' + cp.precio_unidad + '</td>' +
                            '<td align="right">' + cp.precio_unidad_extranjero + '</td>' +
                            '<td align="center"><label class="label label-info">' + cp.estado + '</label></td>' +
                            '</tr>');
                    } else {
                        $('#body_tbl > tbody:last-child').append('<tr>' +
                            '<td>' + cp.id + '</td>' +
                            '<td>' + cp.proveedor + '</td>' +
                            '<td><h4 class="m-b-0 font-16">' + cp.nombre + '</h4></td>' +
                            '<td>' + cp.serie + '</td>' +
                            '<td>' + cp.garantia + '</td>' +
                            '<td align="right">' + cp.precio_unidad + '</td>' +
                            '<td align="right">' + cp.precio_unidad_extranjero + '</td>' +
                            '<td align="center"><label class="label label-success">' + cp.estado + '</label></td>' +
                            '</tr>');
                    }
                });
            }, function(reason) {
                console.log(reason);
            });
            $("#vm_ver_productos").modal("show");
        });
        $(".ver-productos-remision").on('click', function() {
            $("#body_tbl_remision > tbody").empty();
            var obj = new Object();
            obj.remision_id = $(this).attr("remision_id");
            $.ajax({
                url: '<?= base_url('remision/obtener_productos_remision') ?>',
                method: 'POST',
                dataType: "json",
                data: obj
            }).then(function(data) {
                console.log(data);
                data.forEach(function(cp, index) {
                   
                        $('#body_tbl_remision > tbody:last-child').append('<tr>' +
                            '<td>' + cp.id + '</td>' +
                            '<td>' + cp.cod + '</td>' +
                            '<td><h4 class="m-b-0 font-16">' + cp.descripcion + '</h4></td>' +
                            '<td>' + cp.unidad_medida + '</td>' +
                            '<td>' + cp.cantidad + '</td>' +
                           
                            '</tr>');
                   
                    
                });
            }, function(reason) {
                console.log(reason);
            });
            $("#vm_ver_productos_remision").modal("show");
        });
    });
</script>
<script src="https://cdn.datatables.net/buttons/1.5.1/js/buttons.print.min.js"></script>
<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert-dev.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.css">

<script>
    $(document).on('click', '.btn-pendiente', function(e) {
        e.preventDefault();
        serie = $(this).data('serie');
        numero = $(this).data('numero');
        id = $(this).data('id');
        tipo = $(this).data('tipo');
        swal({
                title: "Enviar " + tipo.toUpperCase() + " a SUNAT",
                text: "" + tipo.toUpperCase() + " " + serie + " " + numero,
                //type: "success",
                imageUrl: "envios-sunat/assets/img/invoice.png",
                showCancelButton: true,
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Confirmar Envío",
                cancelButtonText: "Cancelar",
                closeOnConfirm: false
            },
            function() {
                $.ajax({
                    url: 'envios-sunat/sources/' + tipo + '.php?op=2',
                    type: 'POST',
                    data: {
                        'serie': serie,
                        'numero': numero,
                        'id': id
                    },
                    dataType: 'JSON',
                    beforeSend: function() {

                        swal({

                            title: 'Cargando',
                            text: 'Espere un momento',
                            imageUrl: 'envios-sunat/assets/img/loader2.gif',
                            showConfirmButton: false
                        });


                    },
                    success: function(data) {




                        swal({

                            title: data.title,
                            text: data.text,
                            type: data.type
                            //showConfirmButton:false

                        });



                        setInterval(function() {


                            location.reload();

                        }, 3000);




                    }
                });
            });
    });

    function consulta_resumen_ventas(periodo = '', tipo = '') {
        label = "Resumen de Ventas RUC: <?php echo $_SERVER['APP_EMPRESA_RUC']; ?> (" + tipo + ")";
        $(document).ready(function() {

            $('#consulta_resumen_ventas').DataTable({

                dom: 'lBfrtip',

                buttons: [

                    {

                        text: '<i class="fa fa-calendar"></i>',
                        action: function(e, dt, node, config) {


                            $('#modal-resumen-ventas').modal('show');

                        }

                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: label,
                        title: label,
                        sheetName: label,
                    },
                    {
                        extend: 'pdfHtml5',
                        titleAttr: label,
                        title: label,
                        orientation: 'letter',
                        pageSize: 'LEGAL'
                    }


                ],

                "destroy": true,
                "iDisplayLength": 50,
                "bAutoWidth": false,
                "language": {

                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"

                },
                "fnServerParams": function(aoData) {
                    aoData.push(

                        {
                            "name": "periodo",
                            "value": periodo
                        }, {
                            "name": "tipo",
                            "value": tipo
                        }


                    );
                },
                "deferRender": true,
                "bProcessing": true,
                "sAjaxSource": "resumen_ventas",
                "aoColumns": [

                    {
                        mData: "fecha"
                    },
                    {
                        mData: "numero"
                    },
                    {
                        mData: "cliente"
                    },
                    {
                        mData: "documento"
                    },
                    {
                        mData: "subtotal"
                    },
                    {
                        mData: "igv"
                    },
                    {
                        mData: "total"
                    },
                    {
                        mData: "envio"
                    }


                ]

            });

        });

    }
    consulta_resumen_ventas('<?= date('Y-m') ?>', 'factura');
    $(document).on('submit', '#form-resumen-ventas', function(e) {

        periodo = $('.periodo').val();
        tipo = $('.tipo').val();

        consulta_resumen_ventas(periodo, tipo);


        $('#modal-resumen-ventas').modal('hide');

        e.preventDefault();
    });

    function consulta_resumen_ventas_digemid(periodo_inicio = '', periodo_fin = '', tipo = '') {

        label = "Resumen de Ventas RUC: <?php echo $_SERVER['APP_EMPRESA_RUC']; ?> (" + tipo + ")";

        $(document).ready(function() {

            $('#consulta_resumen_ventas_digemid').DataTable({
                dom: 'lBfrtip',
                buttons: [{
                        text: '<i class="fa fa-calendar"></i>',
                        action: function(e, dt, node, config) {
                            $('#modal-resumen-ventas').modal('show');
                        }
                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: label,
                        title: label,
                        sheetName: label
                    }
                ],
                "destroy": true,
                "iDisplayLength": 50,
                "bAutoWidth": false,
                "language": {
                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
                },
                "fnServerParams": function(aoData) {
                    aoData.push({
                        "name": "periodo_inicio",
                        "value": periodo_inicio
                    }, {
                        "name": "periodo_fin",
                        "value": periodo_fin
                    }, {
                        "name": "tipo",
                        "value": tipo
                    });
                },
                "deferRender": true,
                "bProcessing": true,
                "sAjaxSource": "resumen_ventas_digemid",
                "aoColumns": [{
                        mData: "cliente"
                    },
                    {
                        mData: "direccion"
                    },
                    {
                        mData: "ruc"
                    },
                    {
                        mData: "serie",
                        render: function(data) {
                            return (data.startsWith('F') ?
                                "FACTURA" :
                                "BOLETA");
                        }
                    },
                    {
                        mData: "numero"
                    },
                    {
                        mData: "metodo_pago"
                    },
                    {
                        mData: "fecha"
                    },
                    {
                        mData: "vencimiento"
                    },
                    {
                        mData: "detalle_producto"
                    },
                    {
                        mData: "cantidad"
                    },
                    {
                        mData: "precio_unidad",
                        render: function(data) {
                            return `${data} UND`;
                        }
                    },
                    {
                        mData: "igv",
                        render: function(data) {
                            return `S/. ${data}`;
                        }
                    },
                    {
                        mData: "subtotal",
                        render: function(data) {
                            return `S/. ${data}`;
                        }
                    },
                    {
                        mData: "total",
                        render: function(data) {
                            return `S/. ${data}`;
                        }
                    },
                    {
                        mData: "orden_servicio"
                    },
                    {
                        mData: "guia_remision_numeros"
                    },
                    {
                        mData: "bienes"
                    },
                    {
                        mData: "partida_direccion"
                    },
                    {
                        mData: "llegada_direccion"
                    }
                ]
            });
        });
    }
    consulta_resumen_ventas_digemid('<?= date("Y-m") ?>', '<?= date("Y-m") ?>', 'factura');
    $(document).on('submit', '#form-resumen-ventas-digemid', function(e) {

        periodo_inicio = $('.periodo_inicio').val();
        periodo_fin = $('.periodo_fin').val();
        tipo = $('.tipo').val();

        consulta_resumen_ventas_digemid(periodo_inicio, periodo_fin, tipo);

        $('#modal-resumen-ventas-digemid').modal('hide');

        e.preventDefault();
    });
</script>
<script type="text/javascript">
    $(document).on('change', '#frm_guia select[name="serie"]', function() {
        var serie = $('#frm_guia select[name="serie"]').val();
        $.post('<?= base_url('remision/numero') ?>', {
            serie: serie
        }, function(res) {
            if (res.success) {
                $('#frm_guia input[name="numero"]').val(res.numero);
            }
        }, 'json');
    });
    //factura, boleta, nota_credito, nota_debito
    $(document).on('click', 'label[data-cpe="enviar"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        var template = '';
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/enviar"); ?>', {
            id: id,
            serie: serie,
            numero: numero,
            tipo: tipo
        }, function(r) {
            if (r.success) {
                template += r.data.number + ' ';
                template += r.data.state_type_description + '<br>';
                template += '<a target="_blank" href=' + r.links.pdf + '>PDF</a><br>';
                template += '<a target="_blank" href=' + r.links.xml + '>XML</a><br>';
                template += '<a target="_blank" href=' + r.links.cdr + '>CDR</a><br>';
                $('#modal_cpe .modal-body').html(template);
                window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(r.message);
            }
        }, 'json');
    });
    $(document).on('click', 'label[data-cpe="enviar_nota_credito"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        var template = '';
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/enviar_nota_credito"); ?>', {
            id: id,
            serie: serie,
            numero: numero,
            tipo: tipo
        }, function(r) {
            if (r.success) {
                template += r.data.number + ' ';
                template += r.data.state_type_description + '<br>';
                template += '<a target="_blank" href=' + r.links.pdf + '>PDF</a><br>';
                template += '<a target="_blank" href=' + r.links.xml + '>XML</a><br>';
                template += '<a target="_blank" href=' + r.links.cdr + '>CDR</a><br>';
                $('#modal_cpe .modal-body').html(template);
                window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(r.message);
            }
        }, 'json');
    });
    $(document).on('click', 'label[data-cpe="anular"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/anular"); ?>', {
            serie: serie,
            numero: numero,
            id: id,
            tipo: tipo
        }, function(r) {
            console.log(r);
            if (r.success) {
                $('#modal_cpe .modal-body').html("Se envió la anulación: "+r.response.description);
                //window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(JSON.stringify(r));
            }
        }, 'json');
    });
    $(document).on('click', 'label[data-cpe="estado_cpe"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        var template = '';
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/estado_cpe"); ?>', {
            serie: serie,
            numero: numero,
            id: id,
            tipo: tipo
        }, function(r) {
            if (r.success) {
                template += r.data.number + ' ';
                template += r.data.status + '<br>';
                template += '<a target="_blank" href=' + r.links.pdf + '>PDF</a><br>';
                template += '<a target="_blank" href=' + r.links.xml + '>XML</a><br>';
                template += '<a target="_blank" href=' + r.links.cdr + '>CDR</a><br>';
                $('#modal_cpe .modal-body').html(template);
                window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(r.message);
            }
        }, 'json');
    });
    //factura, boleta, nota_credito, nota_debito
    $(document).on('click', 'label[data-cpe="enviar_guia"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var template = '';
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/enviar_guia"); ?>', {
            id: id,
            serie: serie,
            numero: numero
        }, function(r) {
            console.log(r);
            if (r.success) {
                template += r.data.number + ' ';
                template += r.data.state_type_description + '<br>';
                template += '<a target="_blank" href=' + r.links.pdf + '>PDF</a><br>';
                template += '<a target="_blank" href=' + r.links.xml + '>XML</a><br>';
                template += '<a target="_blank" href=' + r.links.cdr + '>CDR</a><br>';
                $('#modal_cpe .modal-body').html(template);
                window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(r.message);
            }
        }, 'json');
    });
    $(document).on('click', 'label[data-cpe="estado_guia"]', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var template = '';
        $('#modal_cpe .modal-body').html('<h1>Por favor espere</h1>');
        $('#modal_cpe').modal('show');
        $.post('<?php echo base_url("cpe/estado_guia"); ?>', {
            serie: serie,
            numero: numero,
            id: id
        }, function(r) {
            if (r.success) {
                template += r.data.number + ' ';
                template += r.data.status + '<br>';
                template += '<a target="_blank" href=' + r.links.pdf + '>PDF</a><br>';
                template += '<a target="_blank" href=' + r.links.xml + '>XML</a><br>';
                template += '<a target="_blank" href=' + r.links.cdr + '>CDR</a><br>';
                $('#modal_cpe .modal-body').html(template);
                window.location.reload();
            } else {
                $('#modal_cpe .modal-body').html(r.message);
            }
        }, 'json');
    });
    $('#modal_cpe').on('hidden.bs.modal', function() {
        setTimeout(location.reload(), 3000);
    });
    $(function() {
        $('.select2').select2({
            placeholder: "Selecciona una opcion",
            allowClear: true
        });
        // Verificar si las funciones están siendo utilizadas
        $('#precioacabado').on('input', function() {
            $('#montoacabado').val(parseFloat($('#precioacabado').val() * $('#cantidadacabado').val()).toFixed(2));
            total();
        });
        $('#cantidadacabado').on('input', function() {
            $('#montoacabado').val(parseFloat($('#precioacabado').val() * $('#cantidadacabado').val()).toFixed(2));
            total();
        });
        $('#descuento').on('input', function() {
            total();
        });
        $('#montodiseno').on('input', function() {
            total();
        });

        function total() {
            var montoproducto = 0;
            $("#tbody_producto tr td:nth-child(10)").each(function() {
                montoproducto = montoproducto + parseFloat($(this).text());
                console.log($(this).text());
            });

            // alert(montoproducto);
            /*
                var montodiseno = $('#montodiseno').val();
                if ($('#montodiseno').val() == null){
                    montodiseno = 0;
                }
                var montoacabado = $('#montoacabado').val();
                if ($('#montoacabado').val() == null){
                    montoacabado = 0;
                }
                $('#montototal').val(parseFloat(montoproducto+parseFloat(montodiseno)+parseFloat(montoacabado)).toFixed(2));
            */
            $('#montototal').val(parseFloat(montoproducto).toFixed(2));
            $('#totalpagar').val(parseFloat($('#montototal').val() - $('#descuento').val()).toFixed(2));
        }


        
        $('#montodiseno').attr("readonly", "readonly");
        $('#diseno').on('change', function() {
            if ($(this).val() == "NO") {
                $('#montodiseno').attr("readonly", "readonly");
                $('#montodiseno').val('0.00');
            } else if ($(this).val() == "SI") {
                $('#montodiseno').attr('readonly', false);
            }
        });

        $('#acabado').on('change', function() {
            var precio = $(this).find(':selected').attr('precio');
            $("#precioacabado").val(precio);
            $('#montoacabado').val(parseFloat($('#precioacabado').val() * $('#cantidadacabado').val()).toFixed(2));
            total();
        });
        //ESTA SECCION PERMITE OCULTAR LAS OPCIONES CUANDO ACABADO ESTE SELECCIONADO COMO NO
        $('#opcionesacabado').hide(); //Debe empezar oculto por que esta No por defecto al cargar
        $('#acabadoopcion').on('change', function() {
            /*
            var precio = $(this).find(':selected').attr('precio');
            $("#precioacabado").val(precio);
            $('#montoacabado').val(parseFloat($('#precioacabado').val()*$('#cantidadacabado').val()).toFixed(2));
            total();*/
            var seleccionacabado = $(this).children("option:selected").val();
            if (seleccionacabado == "SI") {
                $('#opcionesacabado').show();
            } else {
                $('#opcionesacabado').hide();

            }
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado2 = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado2 == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }

            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montodiseno);

            //  console.log(montoacabado);
            // console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));
            //console.log(montoproductosubtotal+montodiseno+montoacabado );
            //console.log($('#montoproducto').val());
        });
        //ESTA SECCION PERMITE OCULTAR LAS OPCIONES CUANDO DISENO ESTE SELECCIONADO COMO NO
        $('#opcionesdiseno').hide(); //Debe empezar oculto por que esta No por defecto al cargar
        $('#diseno').on('change', function() {

            var selecciondiseno = $(this).children("option:selected").val();
            if (selecciondiseno == "SI") {
                $('#opcionesdiseno').show();
            } else {
                $('#opcionesdiseno').hide();

            }
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado2 = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado2 == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }

            var montoproductosubtotal = cantidad * precioproducto * area;
            //console.log(montodiseno);

            //  console.log(montoacabado);
            // console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));
            //console.log(montoproductosubtotal+montodiseno+montoacabado );
            //console.log($('#montoproducto').val());
        });

        $('#acabado').on('change', function() {
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }
            //   console.log(montodiseno);

            //   console.log(montoacabado);



            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));
        });
        $('#cantidadacabado').on('input', function() {
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }
            //   console.log(montodiseno);

            //   console.log(montoacabado);



            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));

        });
        $('#montodiseno').on('input', function() {
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }
            //   console.log(montodiseno);

            //   console.log(montoacabado);



            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));

        });
        $('#largo').on('input', function() {
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());

            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }
            //   console.log(montodiseno);

            //   console.log(montoacabado);



            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montoproductosubtotal);

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));

        });
        $('#ancho').on('input', function() {
            var largo = $('#largo').val();
            var ancho = $('#ancho').val();
            var cantidad = parseFloat($('#cantidad').val());
            var precioproducto = parseFloat($('#precioproducto').val());
            $('#area').val(parseFloat(largo * ancho / 10000).toFixed(2));
            var area = parseFloat($('#area').val());
            var selecciondiseno = $('#diseno').children("option:selected").val();
            if (selecciondiseno == "SI" && $('#montodiseno').val() != '') {
                var montodiseno = parseFloat($('#montodiseno').val());
            } else {
                var montodiseno = parseFloat(0);
            }

            var seleccionacabado = $('#acabadoopcion').children("option:selected").val();
            if (seleccionacabado == "SI" && $('#montoacabado').val() != '') {
                var montoacabado = parseFloat($('#montoacabado').val());
            } else {
                var montoacabado = parseFloat(0);
            }
            //   console.log(montodiseno);

            //   console.log(montoacabado);



            var montoproductosubtotal = cantidad * precioproducto * area;
            //  console.log(montoproductosubtotal);
            // var montototalcondiseno=montoproductosubtotal+montodiseno+montoacabado

            $('#montoproducto').val(parseFloat(montoproductosubtotal + montodiseno + montoacabado).toFixed(2));

        });

        $('#frm-cliente-coti').on('submit', function(e) {
            e.preventDefault();
            var dat = $(this).serializeArray();
            $.ajax({
                url: '<?= base_url('cliente/postCliente') ?>',
                method: 'POST',
                dataType: "json",
                data: dat
            }).then(function(data) {
                if (data != null) {
                    $('#vm_registrar_cliente').modal('toggle');
                    $('#cliente_id').append("<option value = '" + data + "' tipo='" + $('#tipo').val() + "'>" + $('#nombre').val() +
                        " - " + $('#tipo_doc').val() + " - " + $('#numero_doc').val() + $('#direccion').val() + "</option>");
                    $('#numero_doc').val("");
                    $('#nombre').val("") + "-"
                    $('#nombre_comercial').val("");
                    $('#direccion').val("");
                    $('#telefono').val("");
                    $('#correo').val("");
                    $('#telefono').val("");
                    $('#codigo_internacional_id').val("");
                    $('#telefono_ref').val("");
                }
            }, function(reason) {
                console.log(reason);
            });
        });
        $('#frm-add-acabado').on('submit', function(e) {
            e.preventDefault();
            var dat = $(this).serializeArray();
            $.ajax({
                url: '<?= base_url('cotizacion/crearAcabado') ?>',
                method: 'POST',
                dataType: "json",
                data: dat
            }).then(function(data) {
                if (data != null) {
                    $('#vm_registrar_acabado').modal('toggle');
                    $('#acabado').append("<option value = '" + data + "' precio='" + $('#precio_acabado_crear').val() + "'>" + $('#nombre_acabado_crear').val() +
                        " - S/" + $('#precio_acabado_crear').val() + "</option>");
                    $('#nombre_acabado_crear').val("");
                    $('#precio_acabado_crear').val("");
                }
            }, function(reason) {
                console.log(reason);
            });
        });

        $('#registrar_um').on('click', function() {
            var desc = $('#descripcion').val();
            var obj = new Object();
            obj.descripcion = desc;
            if (desc.trim() != "") {
                $.ajax({
                    url: '<?= base_url('producto/guardarUnidadMedida') ?>',
                    method: 'POST',
                    dataType: "json",
                    data: obj
                }).then(function(data) {
                    if (data != null) {
                        $('#vm_registrar_um').modal('toggle');
                        $('#unidad_medida').append("<option value = '" + data + "'>" + desc + "</option>");
                    }
                }, function(reason) {
                    console.log(reason);
                });
            } else {
                alert("La descripcion no puede ser nula.");

            }
        });


        // Verificar sila sig fun esta siendo utilizada en alguna parte
        $('#tbody_producto').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
            var result = "";
            var precio = $(this).find(':selected').attr('precio');
            $("#precioacabado").val(precio);
            $('#montoacabado').val(parseFloat($('#precioacabado').val() * $('#cantidadacabado').val()).toFixed(2));
            total();
        });
        // Verificar si la siguiente funcion está siendo utilizada en alguna parte
        $('#frm-add-producto').on('submit', function(e) {
            e.preventDefault();
            var dat = $('#frm-add-producto').serializeArray();
            var jqxhr = $.ajax({
                url: '<?= base_url('producto/postProductoCotizacion') ?>',
                method: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                async: false,
                success: function(data) {
                    return data;
                }
            }).responseText;
            var precioproducto = $('#precioproducto').val();
            var cantidad = $('#cantidad').val();
            var validezOferta = $('#validezOferta').val();
            var garantiaMeses = $('#garantiaMeses').val();
            var formaPago = $('#formaPago').val();
            var entrega = $('#entrega').val();
            if (cantidad == "") {
                alert("Ingrese cantidad");
                return;
            }
            var montoproducto = $('#montoproducto').val();
            var producto_id = $('#producto_id').val();
            // var tipo_prod = $('#producto_id').val();
            var producto = $("#producto_id option:selected").text();
            // $('.caract').each(function() {
            //     caracteristicas.push($(this).val());
            // });
            // var caracteristica2 = $('#caracteristicaproducto2').val();
            // var caracteristica3 = $('#caracteristicaproducto3').val();
            var marca = $('#marcaproducto').val();
            var procedencia = $('#procedenciaproducto').val();
            //var selecciondiseno = $('#diseno').children("option:selected").val();
            var seriess = '';
            if ($("#series").select2('data') !== undefined && $("#series").select2('data').length) {
                seriess = $("#series").select2('data')[0].text;
            }
            $('#tbody_producto').append(
                '<tr>' +
                '<td>' +
                '<h5 class="m-b-0" >' + producto + '</h5>' +
                '</td>' +
                '<td>' + marca + '</td>' +
                '<td>' + procedencia + '</td>' +

                '<td>' + precioproducto + '</td>' +
                '<td>' + cantidad + '</td>' +
                '<td>' + entrega + '</td>' +
                '<td>' + validezOferta + '</td>' +
                '<td>' + garantiaMeses + '</td>' +
                '<td>' + formaPago + '</td>' +
                '<td>' +
                '<h5 class="m-b-0" >' + montoproducto + '</h5></td>' +
                '<td>' +
                '<a href="#" class="delete"> Eliminar</a>' +
                '<input name="producto_id[]" value="' + producto_id + '~' + jqxhr + '" hidden>' +
                // '<input name="tipo_prod[]" value="'+tipo_prod+'" hidden>'+
                '<input name="precio_unidad[]" value="' + precioproducto + '" hidden>' +
                '<input name="cantidad[]" value="' + cantidad + '" hidden>' +
                '<input name="total[]" value="' + montoproducto + '" hidden>' +
                '<input name="entrega[]" value="' + entrega + '" hidden>' +
                '<input name="validezOferta[]" value="' + validezOferta + '" hidden>' +
                '<input name="garantiaMeses[]" value="' + garantiaMeses + '" hidden>' +
                '<input name="formaPago[]" value="' + formaPago + '" hidden>' +
                '<input name="serie" value="' + seriess + '" hidden>' +
                '</td>' +
                '</tr>');
            var ancho = $('#largo').val(null);
            var largo = $('#ancho').val(null);
            var precioproducto = $('#precioproducto').val(null);
            var cantidad = $('#cantidad').val(null);
            var precioproducto = $('#ancho').val(null);
            var area = $('#area').val(null);
            var montodiseno = $('#montodiseno').val(null);
            var cantidadacabado = $('#cantidadacabado').val(null);
            var montoproducto = $('#montoproducto').val(null);
            var producto_id = $('#producto_id').val(null);
            $('#vm_add_producto').modal('toggle');
            total();
            document.getElementById("frm-add-producto").reset();
            $("#serieToggleObjet").slideUp();
            $("#marcaToggleObjet").slideUp();
            $("#procedenciaToggleObjet").slideUp();
            $("#imagenesToggleObjet").slideUp();
            $("#caracteristicasToggleObjet").slideUp();
            $("#validezToggleObjet").slideUp();
            $("#entregaToggleObjet").slideUp();
            $("#formaPagoToggleObjet").slideUp();
            $("#garantiaToggleObjet").slideUp();
            $('#imagen1').attr("src", "#");
            $('#imagen2').attr("src", "#");
            // $('#precioproducto').val("");
            // $('#cantidad').val("");
            // $('#validezOferta').val("");
            // $('#garantiaMeses').val("");
            // $('#formaPago').val("");
            // $('#entrega').val("");
            // $('#montoproducto').val("");
            // $('#producto_id').val("");
            // $("#producto_id").val("");
            // $('#caracteristicaproducto1').val("");
            // $('#caracteristicaproducto2').val("");
            // $('#caracteristicaproducto3').val("");
            // $('#marcaproducto').val("");
            // $('#procedenciaproducto').val("");
        });

        $('#cliente_tipodocumento_remision').on('change', function() {
            var cliente_tipodocumento = this.value;
            $(".search_document").hide();
            if (cliente_tipodocumento == '1') {
                $("#titulo_nombrecliente").html('Nombre del Cliente');
                $("#titulo_numerodocumento").html('N° de DNI');
                $(".search_document").show();
            } else if (cliente_tipodocumento == '5') {
                console.log('facturrraaa')
                $("#titulo_nombrecliente").html('Razón Social');
                $("#titulo_numerodocumento").html('N° de RUC');
                $(".search_document").show();
            } else {
                $("#titulo_nombrecliente").html('Nombre del Cliente');
                $("#titulo_numerodocumento").html('N° de Documento');
            }
        });


        $(function() {
            $('#imageUploaded1').change(function(e) {
                addImage(e);
            });

            function addImage(e) {
                var file = e.target.files[0],
                    imageType = /image.*/;

                if (!file.type.match(imageType))
                    return;

                var reader = new FileReader();
                reader.onload = fileOnload;
                reader.readAsDataURL(file);
            }

            function fileOnload(e) {
                var result = e.target.result;
                $('#imagen1').attr("src", result);
            }
        });
        $(function() {
            $('#imageUploaded2').change(function(e) {
                addImage(e);
            });

            function addImage(e) {
                var file = e.target.files[0],
                    imageType = /image.*/;

                if (!file.type.match(imageType))
                    return;

                var reader = new FileReader();
                reader.onload = fileOnload;
                reader.readAsDataURL(file);
            }

            function fileOnload(e) {
                var result = e.target.result;
                $('#imagen2').attr("src", result);
            }
        });

        // $('.verificar-cambio').on('change',function(){

        // });
        $('#producto_cantidad').on('input', function() {
            var cantidad = $('#producto_cantidad').val();
            var precio = $('#producto_precio_unidad').val();
            $('#producto_total').val(parseFloat(cantidad * precio).toFixed(2));
        });












        $('#btn-venta-reporte-pollo').on('click', function(e) {
            var fecha = $("#fecha_p").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=pollo_diario&id=2&fecha=" + fecha, "_blank");
        });

        $('#btn-reporte-clientes').on('click', function(e) {
            var fechainicio = $("#fecha_inicio_cliente").val();
            var fechafin = $("#fecha_fin_cliente").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=clientes&id=1&fechainicio=" + fechainicio + "&fechafin=" + fechafin, "_blank");
        });
        $('#btn-reporte-pendientes').on('click', function(e) {
            var estado = $("#estado_p").val();
            var disenador = $("#disenador_p").val();
            var fechainicio = $("#fecha_inicio_p").val();
            var fechafin = $("#fecha_fin_p").val();
            console.log(fechainicio)
            window.open("<?= base_url() ?>" + "prueba?tipo=ventas_pendientes&id=1&fechainicio=" + fechainicio + "&fechafin=" + fechafin + "&disenador=" + disenador + "&estado=" + estado, "_blank");
        });
        $('#btn-dbf').on('click', function(e) {
            var mes = $("#mes_concar").val();
            var ano = $("#ano_concar").val();
            var doc = $("#doc_concar").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=dbf&id=1&mes=" + mes + "&ano=" + ano + "&doc=" + doc, "_blank");
        });
        $('#btn-kardex').on('click', function(e) {
            var id = $("#producto_kardex").val();
            var mes = $("#mes_kardex").val();
            var ano = $("#ano_kardex").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=kardex&id=" + id + "&mes=" + mes + "&ano=" + ano, "_blank");
        });
        $('#cambiar-estado').on('click', function(e) {
            var fecha = $("#fecha").val();
            window.open("<?= base_url() ?>" + "prueba?tipo=venta_diaria&id=2&fecha=" + fecha, "_blank");
        });
        $('.cambiar-estado').on('click', function(e) {
            var venta_id = $(this).attr("data-id");
            var estado = $(this).attr("data-estado");
            $("#venta_id").val(venta_id);
            if (estado == 1) {
                $("#estado").val(2);
                $("#texto").text("En Proceso");
            } else if (estado == 2) {
                $("#estado").val(3);
                $("#texto").text("Terminado");
            }
        });
        $('.terminar-venta').on('click', function(e) {
            var venta_id = $(this).attr("data-id");
            var serienumero = $(this).attr("data-serie-numero");
            $("#venta_id").val(venta_id);
            $("#serie-numero").val(serienumero);
        });
        $('.reprogramar-entrega').on('click', function(e) {
            var venta_id = $(this).attr("data-id");
            var serienumero = $(this).attr("data-serie-numero");
            $("#venta_id-rp").val(venta_id);
            $("#serie-numero-rp").val(serienumero);
        });
        $('.agregar-saldo').on('click', function(e) {
            var venta_id = $(this).attr("data-id");
            var serienumero = $(this).attr("data-serie-numero");
            var saldo = $(this).attr("data-saldo");
            var total = $(this).attr("data-monto");
            $("#venta_id_saldo").val(venta_id);
            $("#serie-numero-saldo").val(serienumero);
            $("#saldo").val(saldo);
            $("#total").val(total);
        });
        $('#recibido').on('input', function(e) {
            if ($('#cotizacion_id').val() == "") {
                $('#recibido').val("");
                return;
            }
            $('#vuelto').val(parseFloat(parseFloat($('#recibido').val()) - parseFloat($('#total').val())).toFixed(2));
        });
        $('#adelanto').on('input', function(e) {
            if ($('#cotizacion_id').val() == "") {
                $('#adelanto').val("");
                return;
            }
            $('#saldo').val(parseFloat(parseFloat($('#total').val()) - parseFloat($('#adelanto').val())).toFixed(2));
        });
        $('#cotizacion_id').on('change', function(e) {
            if ($(this).val() != '') {
                var total = $('#cotizacion_id').find(':selected').attr('totalpagar');
                var diseno = $('#cotizacion_id').find(':selected').attr('montodiseno');
                $('#total').val(total);
                if ($('#formapago').val() == "CONTADO") {
                    if ($('#recibido').val() <= 0 || $('#recibido').val() == "") {
                        $('#recibido').val("0.00");
                    }
                    $('#vuelto').val(parseFloat(parseFloat($('#recibido').val()) - parseFloat($('#total').val())).toFixed(2));
                } else if ($('#formapago').val() == "CREDITO") {
                    if ($('#adelanto').val() <= 0 || $('#adelanto').val() == "") {
                        $('#adelanto').val("0.00");
                    }
                    $('#saldo').val(parseFloat(parseFloat($('#total').val()) - parseFloat($('#adelanto').val())).toFixed(2));
                }
                if (parseFloat(diseno) > 0) {
                    $('#disenador_id').prop('disabled', false);
                } else {
                    $('#disenador_id').val("");
                    $('#disenador_id').attr('disabled', true);
                }
            } else {
                $('#total').val("");
                $('#disenador_id').val("");
                $('#disenador_id').attr('disabled', true);
            }
        });
        $('#formapago').on('change', function(e) {
            if ($(this).val() == "CONTADO") {
                $("#contado").show();
                $("#credito").hide();
                $('#adelanto').val("");
                $('#saldo').val("");
                $('#dias').val("0");
                if ($('#cotizacion_id').val() != "") {
                    $('#recibido').val("0.00");
                }
            } else if ($(this).val() == "CREDITO") {
                $("#contado").hide();
                $("#credito").show();
                $('#recibido').val("");
                $('#vuelto').val("");
                if ($('#cotizacion_id').val() != "") {
                    $('#adelanto').val("0.00");
                    $('#saldo').val(parseFloat(parseFloat($('#total').val()) - parseFloat($('#adelanto').val())).toFixed(2));
                }
            }
        });
        $('#tipo_prod').on('change', function(e) {
            $("#caracteristica").val("");
            $("#unidad_medida").val("");
            if ($(this).val() == "1") {
                $("#tipo_datos").show();
            } else if ($(this).val() == "2") {
                $("#tipo_datos").hide();
            }
        });
        $('#table_compra').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });
        $('#tbody_producto_remision').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });
        $('#tbl-billete').on('click', '.delete', function(e) {
            e.preventDefault();
            $(this).parents('tr').remove();
        });
        $('#frm-venta').on('submit', function(e) {
            var diseno = $('#cotizacion_id').find(':selected').attr('montodiseno');
            if (diseno > 0) {
                if ($("#disenador_id").val() == "") {
                    e.preventDefault();
                    alert("Seleccione al diseÃ±ador encargado");
                    return;
                }
            }
            if ($("#formapago").val() == "CONTADO") {
                if (parseFloat($('#recibido').val()) < parseFloat($('#total').val())) {
                    e.preventDefault();
                    alert("El monto recibido no puede ser menor al total");
                }
            } else if ($("#formapago").val() == "CREDITO") {
                if ($('#adelanto').val() > $('#total').val()) {
                    e.preventDefault();
                    alert("El monto de adelanto no puede ser mayor al total");
                } else if ($("#dias").val() == "0") {
                    e.preventDefault();
                    alert("La cantidad de dias no puede ser cero");
                }
            }
        });
        $('#frm-agregar-saldo').on('submit', function(e) {
            var total = $('#total').val();
            var saldo = $('#saldo').val();
            var saldo_agregar = $('#saldo_agregar').val();
            if (parseFloat(saldo_agregar) > parseFloat(saldo)) {
                e.preventDefault();
                alert("El saldo a agregar no puede ser mayor que el saldo a pagar");
            }
        });
        $("#autorizante_id").on('change', function() {
            val = $(this).children("option:selected").val();
            if (val != "") {
                $("#div_clave").prop('hidden', false);
            } else {
                $("#div_clave").prop('hidden', true);
            }
        });
        $("#validar_clave").on('click', function() {
            if ($(this).text() != "Contrase«Ða validada") {
                var obj = new Object();
                var clave = $("#clave_admin").val();
                $.ajax({
                    url: '<?= base_url('cotizacion/getClaveAdmin') ?>',
                    method: 'POST',
                    dataType: "html",
                    data: 'clave=' + clave
                }).then(function(data) {
                    if (data == 1) {
                        $("#clave_admin").attr('readonly', true);
                        $("#validar_clave").text("Clave validada");
                    } else {
                        alert("La clave de administrador es incorrecta.");
                    }
                }, function(data) {
                    if (data == 1) {
                        $("#clave_admin").attr('readonly', true);
                        $("#validar_clave").text("Clave validada");
                    } else {
                        alert("La clave de administrador es incorrecta.");
                    }
                });
            }
        });
        $('#frm-cot').on('submit', function(e) {
            if (parseFloat($('#montoacabado').val()) > 0 && $('#acabado').val() == "") {
                //  e.preventDefault();
                //  alert("Seleccione el acabado");
            } else if ($('#acabado').val() != "8" && parseFloat($('#montoacabado').val()) <= 0) {
                //  e.preventDefault();
                //  alert("Ingrese el precio y cantidad del acabado");
                //}else if ($('#autorizante_id').val() != "0" && parseFloat($('#descuento').val()) <= 0){
                // e.preventDefault();
                //alert("Ingrese el descuento autorizado o desseleccione el autorizante");
            } else if (parseFloat($('#descuento').val()) > 0 && $('#autorizante_id').val() == "") {
                e.preventDefault();
                alert("Seleccione el autorizante del descuento");
            } else if (parseFloat($('#montototal').val()) < 0) {
                e.preventDefault();
                alert("El monto total no puede ser menor a cero");
            } else if (parseFloat($('#totalpagar').val()) < 0) {
                e.preventDefault();
                alert("El monto total a pagar no puede ser menor a cero");
            } else if ($("#autorizante_id").val() == "0" && $("#descuento").val() > 0) {
                if ($("#validar_clave").text() != "Clave validada") {
                    e.preventDefault();
                    alert("Debes elegir y validar un administrador para aplicar el descuento.");
                }
            }
        });
        $('#agregar_billete').on('click', function(e) {
            if ($("#serie_billete").val() == "") {
                alert("Ingrese la serie del billete");
                return;
            }
            $('#tbl-billete').append(
                '<tr>' +
                '<td>' + $("#monto_billete").val() + '</td>' +
                '<td>' + $("#serie_billete").val() + '</td>' +
                '<td>' +
                '<a href="#" class="delete"> Eliminar</a>' +
                '<input name="monto_billete[]" value="' + $('#monto_billete').val() + '" hidden>' +
                '<input name="serie_billete[]" value="' + $('#serie_billete').val() + '" hidden>' +
                '</td>' +
                '</tr>');
            return;
        });

        $('.modal-img-orden').on('click', function(e) {
            e.preventDefault();

            var file = $(this).data("file");
            var source = "http://localhost/viatmcpro/documentos/remisiones/ordenes/" + file;

            $(".img-documento").attr("src", source);
            $("#modal-img").modal("show");
        });

        $('.modal-img-conformidad').on('click', function(e) {
            e.preventDefault();

            var file = $(this).data("file");
            var source = "http://localhost/viatmcpro/documentos/remisiones/documentos_conformidad/" + file;

            $(".img-documento").attr("src", source);
            $("#modal-img").modal("show");
        });

        // verificar si se usa esta funcion
        const colocar_series_general = (value) => {
			let html = '';
			$.ajax({
					url: '/compra/obtener_series/' + value,
					method: 'GET',
					contentType: "application/json; charset=utf-8",
					dataType: 'json',
					success: function(data) {
							for (var i = 0; i < data.length; i++) {
									html += `
						<option value="${data[i].id}">${data[i].serie}</option>
					`;
							} //end for
							document.getElementById('series').innerHTML = html;
					},
					error: function() {

					}
			});
	};

	/* $('#producto_id').on('select2:select', function(e) {
		colocar_series_general($(this).val());
		$('#producto_id').trigger('select2:change');
	}); */
        /*
        $("#frm-producto").on('submit',function(e){
            if(parseFloat($("#precio_venta_distribuidor").val()) >=  parseFloat($("#precio_venta_normal").val())){
                alert("El precio de venta distribuidor debe ser menor al precio de venta normal.");
                e.preventDefault();
            }else if($("#precio_compra").val() >=  $("#precio_venta_distribuidor").val()){
                alert("El precio de compra debe ser menor al precio de venta.");
                e.preventDefault();
            }
        });*/
        $('#tipo_doc').on('change', function() {
            $("#numero_doc").val("");
            if ($(this).val() == "DNI") {
                $("#numero_doc").attr('maxlength', '8');
            } else if ($(this).val() == "RUC") {
                $("#numero_doc").attr('maxlength', '11');
            }
        });
        $('#buscar_doc').on('click', function() {
            if ($('#tipo_doc').val() == "DNI") {
                consultar_dni($('#numero_doc').val());
            } else if ($('#tipo_doc').val() == "RUC") {
                consultar_ruc($('#numero_doc').val());
            }
        });

        function consultar_dni(dni) {
            $("#textobut").text("Buscando...");
            $("#buscar_doc").prop('buscar_doc', true);
            $.ajax({
                url: 'https://cors-anywhere.herokuapp.com/http://aplicaciones007.jne.gob.pe/srop_publico/Consulta/Afiliado/GetNombresCiudadano?DNI=' + dni,
                //data: {num_documento: ruc, tipo: 'ruc'},
                method: 'GET',
                dataType: "html"
            }).then(function(data) {
                console.log(String(data).trim());
                if (String(data).substring(0, 3) == '|||') {
                    alert("ERROR, DNI NO ENCONTRADO");
                } else {
                    $("#nombre").val((data.replace("|", " ")).replace("|", " "));
                    $("#direccion").val('-');
                }
                $("#textobut").text("Buscar");
                $("#buscar_doc").prop('buscar_doc', false);
            });
        }

        function consultar_ruc(ruc) {
            $("#textobut").text("Buscando...");
            $("#buscar_doc").prop('buscar_doc', true);
            $.ajax({
                url: 'https://cors-anywhere.herokuapp.com/http://apologrupo.com/sunat/index.php/Welcome/ruc/' + ruc,
                data: {
                    ruc: ruc
                },
                method: 'GET',
                dataType: "json"
            }).then(function(data) {
                console.log(data);
                $("#textobut").text("Buscar");
                $("#buscar_doc").prop('buscar_doc', false);
                if (data == null) {
                    alert("ERROR, RUC NO ENCONTRADO");
                    return;
                }

                $("#nombre").val(data.Bk_RucRazonSocial);
                $("#direccion").val(data.Direccion);
            }, function(reason) {
                alert("ERROR, RUC NO ENCONTRADO");
            });
        }
    });
    $(document).ready(function() {
        $('.btn-reporte-compra').on('click', function(e) {
           
           $.redirect('<?= base_url('prueba/reporte_compra') ?>', {
              
           }, "POST", "_blank");
       });

        $('#consulta_factura').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true,
            "sAjaxSource": "pendientes/facturas",
            "aoColumns": [{
                    mData: "serie"
                },
                {
                    mData: "numero"
                },
                {
                    mData: "ruc"
                },
                {
                    mData: "cliente"
                },
                {
                    mData: "fecha"
                },
                {
                    mData: "total"
                },
                {
                    mData: "dias_transcurridos"
                },
                {
                    mData: null,
                    render: function(data) {
                        if (data.dias_transcurridos >= 7) {
                            return '<label class="label label-danger">excedio el limite máximo de envio</label> ';
                        } else {
                            return '<label class="label label-warning btn-generarxml" data-serie="' + data.serie + '" data-numero="' + data.numero + '" data-id="' + data.id + '" data-tipo="factura">Generar XML</label> ';
                        }
                    }
                },
                {
                    mData: null,
                    render: function(data) {
                        if (data.dias_transcurridos >= 7) {
                            return '<label   class="label label-danger">excedio el limite máximo de envio</label> ';
                        } else {
                            return '<label   class="label label-warning btn-pendiente" data-serie="' + data.serie + '" data-numero="' + data.numero + '" data-id="' + data.id + '" data-tipo="factura">Pendiente</label> ';
                        }
                    }
                }
                ,
                {
                    mData: "estado_api"
                },
            ]
        });

        $('#tabla-cotizaciones-pendientes').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#tabla-cotizaciones-aceptadas').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#facturas_aceptadas').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#boletas_aceptadas').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#facturas_anuladas').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#boletas_anuladas').DataTable({
            "destroy": true,
            "iDisplayLength": 10,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true
        });

        $('#consulta_boleta').DataTable({
            "destroy": true,
            "iDisplayLength": 50,
            "bAutoWidth": false,
            "language": {
                "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"
            },
            "deferRender": true,
            "bProcessing": true,
            "sAjaxSource": "pendientes/boletas",
            "aoColumns": [{
                    mData: "serie"
                },
                {
                    mData: "numero"
                },
                {
                    mData: "dni"
                },
                {
                    mData: "cliente"
                },
                {
                    mData: "fecha"
                },
                {
                    mData: "total"
                },
                {
                    mData: "dias_transcurridos"
                },
                {
                    mData: null,
                    render: function(data) {
                        if (data.dias_transcurridos >= 7) {
                            return '<label class="label label-danger">excedio el limite máximo de envio</label> ';
                        } else {
                            return '<label class="label label-warning btn-generarxml" data-serie="' + data.serie + '" data-numero="' + data.numero + '" data-id="' + data.id + '" data-tipo="boleta">Generar XML</label> ';
                        }
                    }
                },
                {
                    mData: null,
                    render: function(data) {
                        if (data.dias_transcurridos >= 7) {
                            return '<label class="label label-danger">excedio el limite máximo de envio</label> ';
                        } else {
                            return '<label class="label label-warning btn-pendiente" data-serie="' + data.serie + '" data-numero="' + data.numero + '" data-id="' + data.id + '" data-tipo="boleta">Pendiente</label> ';
                        }
                    }
                }
                ,
                {
                    mData: "estado_api"
                },
            ]
        });
        CargarUbigeo();
    });
    /**
     * Botón que envía petición para obtener el estado de SUNAT
     */
    $(document).on('click', '.btn_estado_sunat', function(e) {

        // Obtener variables para petición
        var factura_id = $(this).data("facturaid");
        var numero_ruc_emisor = <?php echo $_SERVER['APP_EMPRESA_RUC'] ?>;
        var codigo_tipo_documento = $(this).data("tipo");
        var serie_documento = $(this).data("serie");
        var numero_documento = $(this).data("numero");
        var fecha_de_emision = $(this).data("fecha");
        var total = $(this).data("total");

        // Objeto de tipo FormData para petición ajax
        var fd = new FormData();
        fd.append('numero_ruc_emisor', numero_ruc_emisor);
        fd.append('codigo_tipo_documento', codigo_tipo_documento);
        fd.append('serie_documento', serie_documento);
        fd.append('numero_documento', numero_documento);
        fd.append('fecha_de_emision', fecha_de_emision);
        fd.append('total', total);


        $.ajax({
            url: '<?= base_url('Venta/revisarEstadoSunat') ?>',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.blockUI({
                    baseZ: 9999,
                    css: {
                        border: 'none',
                        padding: '15px',
                        backgroundColor: '#000',
                        '-webkit-border-radius': '10px',
                        '-moz-border-radius': '10px',
                        opacity: .5,
                        color: '#fff'
                    }
                });


            },
            complete: function(data) {
                console.log(data);
                $.unblockUI();
            },
            error: function(e) {
                alert('ha ocurrido un error al buscar el estado SUNAT');
                console.log(e);
            },
            success: function(data) {
             
                var estado = data.data.comprobante_estado_descripcion;
                
                $.ajax({
                    url: '<?= base_url('Venta/EstadoSunat') ?>',
                    type: 'POST',
                    data: {
                        'tipo': codigo_tipo_documento,
                        'estado': estado,
                        'id': factura_id
                    },
                    dataType: 'JSON',
                    success: function(data) {
                        console.log(data);
                        // Si la petición obtiene un resultado, mostrar modal con el estado SUNAT
                        swal({
                                title: "Estado SUNAT",
                                text: estado,
                                showConfirmButton: true,
                                confirmButtonText: "Aceptar",
                                allowOutsideClick: false

                            }, function(isConfirm) {
                                if (isConfirm) {
                                    
                                    window.location.reload();
                                }
                            }

                        );
                    }
                });
            }
        });
        e.preventDefault();
    });
    $(document).on('click', '.btn-generarxml', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        swal({
            title: "Generar XML?",
            text: tipo.toUpperCase() + " " + serie + " " + numero,
            imageUrl: "envios-sunat/assets/img/invoice.png",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Generar XML",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: 'envios-sunat/sources/' + tipo + '.php?op=generarxml',
                type: 'POST',
                data: {
                    'serie': serie,
                    'numero': numero,
                    'id': id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    swal({
                        title: 'Generando',
                        text: 'Espere un momento',
                        imageUrl: 'envios-sunat/assets/img/loader2.gif',
                        showConfirmButton: false
                    });
                },
                success: function(data) {
                    swal({
                        title: 'Info',
                        text: data.mensaje
                    });
                    setInterval(function() {
                        location.reload();
                    }, 3000);
                }
            });
        });
        e.preventDefault();
    });
    $(document).on('click', '.btn_anular_comprobante', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        swal({
            title: "Anular " + tipo.toUpperCase() + " ?",
            text: tipo.toUpperCase() + " " + serie + " " + numero,
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "SI",
            cancelButtonText: "CANCELAR",
            closeOnConfirm: false
        }, function() {
            var p = {
                'serie': serie,
                'numero': numero,
                'id': id
            };
            $.post('envios-sunat/sources/' + tipo + '.php?op=anular', p, function(r) {
                swal({
                    title: 'Info',
                    text: r.mensaje
                });
                if (!p.error) {
                    setInterval(function() {
                        location.reload();
                    }, 3000);
                }
            }, 'json').done(function(r) {

            });
        });
        e.preventDefault();
    });
    //script para guia electronica
    $('#frm_guia').on('submit', function(e) {
        console.log('agregar validaciones');
        var motivo_traslado_codigo = $('#motivo_traslado').find(':selected').data('codigo_sunat');
        var modalidad_transporte_codigo = $('#modalidad_transporte').find(':selected').data('codigo_sunat');
        $('#frm_guia').find('input[name="hid_motivo_traslado_codigo"]').val(motivo_traslado_codigo);
        $('#frm_guia').find('input[name="hid_modalidad_transporte_codigo"]').val(modalidad_transporte_codigo);
        //e.preventDefault();
        //return false;
    });
    $('#frm-add-producto-remision').on('submit', function(e) {
        e.preventDefault();
        var dat = $('#frm-add-producto-remision').serializeArray();
        var jqxhr = $.ajax({
            url: '<?= base_url('producto/postProductoRemision') ?>',
            type: 'POST',
            cache: false,
            data: dat,
            async: false,
            success: function(data) {
                return data;
            }
        }).responseText;
        var cantidad = $('#cantidad').val();
        if (cantidad == "") {
            alert("Ingrese cantidad");
            return;
        }
        var cod = $('#cod').val();
        var descripcion = $('#descripcion').val();
        // var tipo_prod = $('#producto_id').val();
        var unidad_medida = $("#unidad_medida").val();
        //var selecciondiseno = $('#diseno').children("option:selected").val();

        var trHtml = '<td>' +
            '<h5 class="m-b-0" >' + cod + '</h5>' +
            '</td>' +
            '<td>' + descripcion + '</td>' +
            '<td>' + unidad_medida + '</td>' +
            '<td>' + cantidad + '</td>' +
            '<td>' +
            '<a href="#" class="delete"> Eliminar</a>' +
            '<a href="javascript:void()" class="edit"> Editar</a>' +
            '<input name="id_remision_producto[]" value="' + jqxhr + '" hidden>' +
            '<input name="codigo_producto[]" value="' + cod + '" hidden>' +
            // '<input name="tipo_prod[]" value="'+tipo_prod+'" hidden>'+
            '<input name="descripcion[]" value="' + descripcion + '" hidden>' +
            '<input name="unidad_medida[]" value="' + unidad_medida + '" hidden>' +
            '<input name="cantidad[]" value="' + cantidad + '" hidden>' +
            '</td>';

        if (updating) {
            $('#tbody_producto_remision tr[data-product-id=' + jqxhr + ']').html(trHtml);
        } else {
            $('#tbody_producto_remision').append('<tr data-product=\'' + JSON.stringify(dat).replace(/'/g, "\\'") + '\' data-product-id="' + jqxhr + '">' + trHtml + '</tr>');
        }

        $('#cod').val('');
        $('#descripcion').val('');
        $('#cantidad').val('');
        $("#unidad_medida").val('');
        $('#vm_add_producto').modal('toggle');
        document.getElementById("frm-add-producto-remision").reset();
        updating=false;
    });

    function CargarUbigeo() {
        var sel_departamento_partida = $('#sel_departamento_partida');
        var sel_provincia_partida = $('#sel_provincia_partida');
        var sel_distrito_partida = $('#sel_distrito_partida');
        var sel_departamento_llegada = $('#sel_departamento_llegada');
        var sel_provincia_llegada = $('#sel_provincia_llegada');
        var sel_distrito_llegada = $('#sel_distrito_llegada');
        var ubigeo_llegada = $('#ubigeo_llegada');
        var ubigeo_partida = $('#ubigeo_partida');
        $.get('https://api.escienza.es/api/v1/departaments', function(r) {
            if (r.success) {
                $.each(r.data, function(i, item) {
                    $(sel_departamento_partida).append($('<option>').val(item.id).text(item.name));
                    $(sel_departamento_llegada).append($('<option>').val(item.id).text(item.name));
                });
            }
        }, 'json').done(function() {
            sel_departamento_partida.select2();
            sel_departamento_llegada.select2();
        });
        sel_departamento_partida.on('change', function() {
            var codigoDepartamento = sel_departamento_partida.val();
            sel_provincia_partida.html('');
            sel_distrito_partida.html('');
            ubigeo_partida.val('');
            $.get('https://api.escienza.es/api/v1/departaments/' + codigoDepartamento + '/provinces', function(r) {
                if (r.success) {
                    sel_provincia_partida.append($('<option>').val('-1').text('.:Seleccione:.'));
                    $.each(r.data, function(i, item) {
                        sel_provincia_partida.append($('<option>').val(item.id).text(item.name));
                    });
                }
            }, 'json').done(function() {
                sel_provincia_partida.select2();
            });
        });
        sel_provincia_partida.on('change', function() {
            var codigoDepartamento = sel_departamento_partida.val();
            var codigoProvincia = sel_provincia_partida.val();
            sel_distrito_partida.html('');
            ubigeo_partida.val('');
            $.get('https://api.escienza.es/api/v1/departaments/' + codigoDepartamento + '/provinces/' + codigoProvincia + '/districts', function(r) {
                if (r.success) {
                    sel_distrito_partida.append($('<option>').val('-1').text('.:Seleccione:.'));
                    $.each(r.data, function(i, item) {
                        sel_distrito_partida.append($('<option>').val(item.id).text(item.name));
                    });
                }
            }, 'json').done(function() {
                sel_distrito_partida.select2();
            });
        });
        sel_distrito_partida.on('change', function() {
            var codigoDistrito = sel_distrito_partida.val();
            $('#departamento_partida').val(sel_departamento_partida.find('option:selected').text());
            $('#provincia_partida').val(sel_provincia_partida.find('option:selected').text());
            $('#distrito_partida').val(sel_distrito_partida.find('option:selected').text());
            ubigeo_partida.val(codigoDistrito);
        });
        sel_departamento_llegada.on('change', function() {
            var codigoDepartamento = sel_departamento_llegada.val();
            sel_provincia_llegada.html('');
            sel_distrito_llegada.html('');
            ubigeo_llegada.val('');
            $.get('https://api.escienza.es/api/v1/departaments/' + codigoDepartamento + '/provinces', function(r) {
                if (r.success) {
                    sel_provincia_llegada.append($('<option>').val('-1').text('.:Seleccione:.'));
                    $.each(r.data, function(i, item) {
                        sel_provincia_llegada.append($('<option>').val(item.id).text(item.name));
                    });
                }
            }, 'json').done(function() {
                sel_provincia_llegada.select2();
            });
        });
        sel_provincia_llegada.on('change', function() {
            var codigoDepartamento = sel_departamento_llegada.val();
            var codigoProvincia = sel_provincia_llegada.val();
            sel_distrito_llegada.html('');
            ubigeo_llegada.val('');
            $.get('https://api.escienza.es/api/v1/departaments/' + codigoDepartamento + '/provinces/' + codigoProvincia + '/districts', function(r) {
                if (r.success) {
                    sel_distrito_llegada.append($('<option>').val('-1').text('.:Seleccione:.'));
                    $.each(r.data, function(i, item) {
                        sel_distrito_llegada.append($('<option>').val(item.id).text(item.name));
                    });
                }
            }, 'json').done(function() {
                sel_distrito_llegada.select2();
            });
        });
        sel_distrito_llegada.on('change', function() {
            var codigoDistrito = sel_distrito_llegada.val();
            $('#departamento_llegada').val(sel_departamento_llegada.find('option:selected').text());
            $('#provincia_llegada').val(sel_provincia_llegada.find('option:selected').text());
            $('#distrito_llegada').val(sel_distrito_llegada.find('option:selected').text());
            ubigeo_llegada.val(codigoDistrito);
        });
    }
</script>
<script>
    $(document).on('click', '#btn_buscar_cliente', function(e) {

        numero = $('#cliente_numero_documento').val();

        if (numero !== '') {


            $.ajax({

                url: 'https://cors-anywhere.herokuapp.com/http://apologrupo.com/sunat/index.php/Welcome/ruc/' + numero,
                type: 'GET',
                data: {
                    'ruc': numero
                },
                dataType: 'JSON',
                method: 'GET',
                beforeSend: function() {

                    swal({

                        title: 'Cargando',
                        text: 'Espere un momento',
                        imageUrl: 'https://raw.githubusercontent.com/claudito/curso-php/master/semana04/img/loader2.gif',
                        showConfirmButton: false
                    });


                },
                success: function(data) {


                    if (data == null) {

                        swal({

                            title: 'Error',
                            text: 'Posiblemente el documento enviado no existe',
                            type: 'error',
                            timer: 3000
                            //showConfirmButton:false


                        });

                    } else {

                        //Bk_RucRazonSocial
                        $('#cliente_nombre').val(data.Bk_RucRazonSocial);
                        if (($("#direccion").length)) {
                            $('#direccion').val(data.Direccion);
                        } //end if

                        swal({

                            title: 'Buen Trabajo',
                            text: 'Registro Encontrado',
                            type: 'success',
                            timer: 2000
                            //showConfirmButton:false


                        });

                    }



                }




            });


        } else {


            swal({

                title: 'Registro Vacio',
                text: 'Necesita Ingresar el Número de Documento',
                type: 'info',
                timer: 3000
                //showConfirmButton:false


            });

        }


        e.preventDefault();
    });

    $(document).on('click', '#btn_buscar_transportista', function(e) {
        numero = $('#transportista_ruc').val();
        if (numero !== '') {
            $.ajax({
                url: 'https://cors-anywhere.herokuapp.com/http://apologrupo.com/sunat/index.php/Welcome/ruc/' + numero,
                type: 'GET',
                data: {
                    'ruc': numero
                },
                dataType: 'JSON',
                method: 'GET',
                beforeSend: function() {
                    swal({
                        title: 'Cargando',
                        text: 'Espere un momento',
                        imageUrl: 'https://raw.githubusercontent.com/claudito/curso-php/master/semana04/img/loader2.gif',
                        showConfirmButton: false
                    });
                },
                success: function(data) {
                    if (data == null) {
                        swal({
                            title: 'Error',
                            text: 'Posiblemente el documento enviado no existe',
                            type: 'error',
                            timer: 3000
                        });

                    } else {
                        $('#transportista_nombre').val(data.Bk_RucRazonSocial);
                        if (($("#transportista_direccion").length)) {
                            $('#transportista_direccion').val(data.Direccion);
                        } //end if
                        swal({
                            title: 'Buen Trabajo',
                            text: 'Registro Encontrado',
                            type: 'success',
                            timer: 2000
                        });
                    }
                }
            });
        } else {
            swal({
                title: 'Registro Vacio',
                text: 'Necesita Ingresar el Número de Documento',
                type: 'info',
                timer: 3000
            });
        }
        e.preventDefault();
    });
</script>
<script>
    function consulta_resumen_compras(periodo = '') {


        label = "Resumen de Compras RUC: 20546439268";

        $(document).ready(function() {

            $('#consulta_resumen_compras').DataTable({

                dom: 'lBfrtip',

                buttons: [

                    {

                        text: '<i class="fa fa-calendar"></i>',
                        action: function(e, dt, node, config) {


                            $('#modal-resumen-compras').modal('show');

                        }

                    },
                    {
                        extend: 'excelHtml5',
                        titleAttr: label,
                        title: label,
                        sheetName: label,
                    },
                    {
                        extend: 'pdfHtml5',
                        titleAttr: label,
                        title: label,
                        orientation: 'letter',
                        pageSize: 'LEGAL'
                    }


                ],
                "order": [
                    [4, 'desc']
                ],
                "destroy": true,
                "iDisplayLength": 50,
                "bAutoWidth": false,
                "language": {

                    "url": "https://cdn.datatables.net/plug-ins/1.10.19/i18n/Spanish.json"

                },
                "fnServerParams": function(aoData) {
                    aoData.push(

                        {
                            "name": "periodo",
                            "value": periodo
                        }


                    );
                },
                "deferRender": true,
                "bProcessing": true,
                "sAjaxSource": "resumen_compra_productos",
                "aoColumns": [

                    {
                        mData: "serie"
                    },
                    {
                        mData: "numero"
                    },
                    {
                        mData: "fecha"
                    },
                    {
                        mData: "nombre"
                    },
                    {
                        mData: "precio_unidad"
                    },
                    {
                        mData: "total"
                    }



                ]






            });

        });




    }
    consulta_resumen_compras('<?= date('Y-m') ?>');
    $(document).on('submit', '#form-resumen-compras', function(e) {

        periodo = $('.periodo').val();

        consulta_resumen_compras(periodo);


        $('#modal-resumen-compras').modal('hide');

        e.preventDefault();
    });
    $(document).on('click', '.btn-generarxml', function(e) {
        var serie = $(this).data('serie');
        var numero = $(this).data('numero');
        var id = $(this).data('id');
        var tipo = $(this).data('tipo');
        swal({
            title: "Generar XML?",
            text: tipo.toUpperCase() + " " + serie + " " + numero,
            imageUrl: "envios-sunat/assets/img/invoice.png",
            showCancelButton: true,
            confirmButtonClass: "btn-danger",
            confirmButtonText: "Generar XML",
            cancelButtonText: "Cancelar",
            closeOnConfirm: false
        }, function() {
            $.ajax({
                url: 'envios-sunat/sources/' + tipo + '.php?op=generarxml',
                type: 'POST',
                data: {
                    'serie': serie,
                    'numero': numero,
                    'id': id
                },
                dataType: 'JSON',
                beforeSend: function() {
                    swal({
                        title: 'Generando',
                        text: 'Espere un momento',
                        imageUrl: 'envios-sunat/assets/img/loader2.gif',
                        showConfirmButton: false
                    });
                },
                success: function(data) {
                    swal({
                        title: 'Info',
                        text: data.mensaje
                    });
                    setInterval(function() {
                        location.reload();
                    }, 3000);
                }
            });
        });
        e.preventDefault();
    });

    function searchInSalesTable() {
        var tipoDeComprobante = $('#table-filter').val();
        var numeroDeSerie = $('#table-serie').val();

        if (tipoDeComprobante !== 'all') {
            document.cookie = "tipoComprobante=" + tipoDeComprobante + "; path=/";
        } else {
            document.cookie = "tipoComprobante=all; path=/";
        }

        if (numeroDeSerie !== 'all') {
            document.cookie = "serieNumber=" + numeroDeSerie + "; path=/";
        } else {
            document.cookie = "serieNumber=all; path=/";
        }

        window.location.reload();
    }

    function loadSeries() {
        var currentSerie = $("#serieNumber").val();
        var currentType = $('#tipoComprobante').val();
        var tableSerie = $('#table-serie');
        var series = JSON.parse(tableSerie.attr('data-series'));
        var allSeries = [];

        tableSerie.html('');

        if (currentType === 'all') {
            series.boleta.forEach(function(v) {
                allSeries.push(v);
            });

            series.factura.forEach(function(v) {
                allSeries.push(v);
            });
        } else if (currentType === 'boleta') {
            series.boleta.forEach(function(v) {
                allSeries.push(v);
            });
        } else if (currentType === 'factura') {
            series.factura.forEach(function(v) {
                allSeries.push(v);
            });
        }

        var defaultSerie = new Option('TODOS', 'all', true, currentSerie === 'all');
        tableSerie.append(defaultSerie);

        allSeries.forEach(function(serie) {
            var o = new Option(serie, serie, false, currentSerie === serie);
            $('#table-serie').append(o);
        });
    }
    $("#table-filter").on('change', function() {
        $('#tipoComprobante').val(this.value);
        loadSeries();
    });
    $(document).ready(function() {
        //loadSeries();
    });
</script>
</body>

</html>