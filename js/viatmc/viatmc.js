function time_alert(type, title, message_html, time) {
  return new Promise((resolve, reject) => {
      Swal.fire({
          position: 'center',
          icon: type,
          title: title,
          html: message_html,
          showConfirmButton: false,
          timer: time
      }).then(() => resolve(true));
  })
}
function ok_alert(type, title, message_html) {
  return new Promise((resolve, reject) => {
      Swal.fire({
          position: 'center',
          icon: type,
          title: title,
          html: message_html,
      }).then(() => resolve(true));
  })
}
function msg_confirmation(type, title, message_html) {
  return new Promise((resolve, reject) => {
      Swal.fire({
          title: title,
          html: message_html,
          icon: type,
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: '<i class="fa fa-check" aria-hidden="true"></i> Aceptar',
          cancelButtonText: '<i class="fa fa-close" aria-hidden="true"></i> Cancelar'
      }).then((result) => {
          if (result.value)
              resolve(true);
          resolve(false);
      });
  });
}
$('.flotantes2decimales').on('keyup', function() {
  var regex = /^\d+(\.\d{0,2})?$/g;
  if(!regex.test(this.value)) this.value = this.value.substring(0, this.value.length-1);
});