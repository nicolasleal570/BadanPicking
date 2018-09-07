/** 
     * 
     * CAMBIANDO EL COLOR DE LAS LETRAS DEL LOGIN
     * 
     * INPUT USUARIO
    */
   $('#user').focus(function () {
    $(".user").css({
      "color":"rgba(23, 135, 252, 0.7)",
      "font-size": "1.8em"
    });
  });
  $('#user').blur(function () {
    $(".user").css({
      "color":"#000",
      "font-size": "1.2em"
    });
  });

  /** 
   * 
   * INPUT PASSWORD
   * 
  */
  $('#password').focus(function () {
    $(".password").css({
      "color":"rgba(23, 135, 252, 0.7)",
      "font-size": "1.8em"
    });
  });
  $('#password').blur(function () {
    $(".password").css({
      "color":"#000",
      "font-size": "1.2em"
    });
  });