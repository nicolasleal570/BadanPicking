$(document).ready(function(){ 

  /** 
   * 
   * CREANDO LA FUNCION PARA ESCONDER LA TABLA SELECCIONADA
   * 
  */
  $(".btn_abrir").click(function () {
    
    $(this).parents("table").css({
      "display": "none"
    });
    
  })



});
