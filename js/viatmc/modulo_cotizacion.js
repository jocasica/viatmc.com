// contraer campos de datos de la cotización
$("#marcaToggleObjet").slideUp();
$("#modeloToggleObjet").slideUp();
$("#procedenciaToggleObjet").slideUp();
$("#imagenesToggleObjet").slideUp();
$("#validezToggleObjet").slideUp();
$("#entregaToggleObjet").slideUp();
$("#formaPagoToggleObjet").slideUp();
$("#garantiaToggleObjet").slideUp();

function calcular_total_producto() {
  const cantidad  = $('#cantidad').val();
  const precio    = $('#precioproducto').val();
  $('#montoproducto').val(parseFloat(cantidad * precio).toFixed(2));
}

// Calcula el monto total del producto
$('#precioproducto').on('input', function() {
  calcular_total_producto();
});

$('#cantidad').on('input', function() {
  calcular_total_producto();
});

// contraer y descontraer campos de entrada (modal add producto)
$(".toggle_check").change(function() {
  $(this).parent().parent().find('.toggle_object').slideToggle();
});

// Donde se usa esta función....?
$('#producto_id').on('change', function() {
  console.log('mmmmm');
  var pnormal = $('#producto_id').find(':selected').attr('normal');
  //console.log(pnormal);
  // var pdistribuidor = $('#producto_id').find(':selected').attr('distribuidor');
  //var tipo_prod = $('#producto_id').find(':selected').attr('tipo');
  //var tipo_cliente = $('#cliente_id').find(':selected').attr('tipo');


  $('#precioproducto').val(pnormal);

  $('#marcaproducto').val($('#producto_id').find(':selected').attr('marca'));
  $('#procedenciaproducto').val($('#producto_id').find(':selected').attr('procedencia'));
  if ($('#producto_id').find(':selected').attr('image') !== undefined) {
      $('#imagen1').attr('src', '<?= base_url() ?>' + $('#producto_id').find(':selected').attr('image'));
      $('#image1Set').val($('#producto_id').find(':selected').attr('image'));
  }
  $('#caracteristicaproducto1').val($('#producto_id').find(':selected').attr('caracteristica1'));
  $('#caracteristicaproducto2').val($('#producto_id').find(':selected').attr('caracteristica2'));
  $('#caracteristicaproducto3').val($('#producto_id').find(':selected').attr('caracteristica3'));
  var cantidad = $('#cantidad').val();
  var precio = $('#precioproducto').val();
  $('#montoproducto').val(parseFloat(cantidad * precio).toFixed(2));
  //total();
});
