$(document).ready(function(){

  // MENU DE LA VENTANA PICKING==================================================
  var estado = false;

  $('#btn-toggle').click(function() {
    $('#seccionToggle').slideToggle();

    if (estado == true) {
      $(this).text("Información Importante. Click Aquí");
      $(this).css({
        "background": "rgb(23, 135, 252)"
      })
      $('body').css({
        "overflow": "auto"
      });
      estado = false;
    }else {
      $(this).text("Cerrar");
      $(this).css({
        "background":"#af0000"
      });
      $('body').css({
        "overflow": "hidden"
      });
      estado = true;
    }
  });

});
