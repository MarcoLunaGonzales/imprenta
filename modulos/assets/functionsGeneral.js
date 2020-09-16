 //cambiar estilos dentro de los iframe
$(document).ready(function() {
	cargarEstilosIframe();
	$("body").attr("style","visibility:visible !important;background:none;");
});

function cargarEstilosIframe(){
	//cabecera css	
 	 $('#cuerpo_frame').contents().find("head").append('<link href="../modulos/assets/vendor/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">'+
      '<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">'+
      '<link href="../modulos/assets/vendor/css/sb-admin-2.min.css" rel="stylesheet"><link href="../modulos/assets/new-styleIframe.css" rel="stylesheet">');

 	 //pie js
 	 $('#cuerpo_frame').contents().find("body").append('<script src="../modulos/assets/vendor/vendor/jquery/jquery.min.js"></script>'+
      '<script src="../modulos/assets/vendor/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>'+
      '<script src="../modulos/assets/vendor/vendor/jquery-easing/jquery.easing.min.js"></script>'+
      '<script src="../modulos/assets/vendor/js/sb-admin-2.min.js"></script>'+
      '<script src="../modulos/assets/vendor/vendor/chart.js/Chart.min.js"></script>'+
      '<script src="../modulos/assets/vendor/js/demo/chart-area-demo.js"></script>'+
      '<script src="../modulos/assets/vendor/js/demo/chart-pie-demo.js"></script>'+
      '<script src="../modulos/assets/functionsGeneralIFrame.js"></script>');
}

 

$("#accordionSidebar li a").on("click",function(){
  $("#titulo_menu_frame").html($(this).html());
});
