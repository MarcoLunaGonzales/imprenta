
function cargarClasesFrame(){
   $(":text").addClass("form-control");
   $(":text").attr("autocomplete","off");
   $("textarea").addClass("form-control");
   $("select").addClass("select-css");
   $("table").addClass("table");
   $("table").addClass("table-sm");
   $("table").addClass("table-success");
   $(":button").removeClass("boton");
   $(":button").addClass("btn");
   $(":button").addClass("btn-sm");
   $(":button").addClass("btn-success");

   $(":reset").removeClass("boton");
   $(":reset").addClass("btn");
   $(":reset").addClass("btn-sm");
   $(":reset").addClass("btn-success");
   
   $("a").attr("target","cuerpo");

   /*enlaces dentro de tabla*/
   $("table tr td a").each( function () {
      $(this).addClass("btn");
      $(this).addClass("btn-sm");

      switch($(this).html().toLowerCase().trim()){
         case "detalle":
           $(this).attr("title",$(this).html());
           $(this).html("<i class='fas fa-fw fa-list'></i>");
           $(this).addClass("btn-warning");
           $(this).addClass("text-white");
         break;
         case "editar":
           $(this).attr("title",$(this).html());
           $(this).html("<i class='fas fa-fw fa-edit'></i>");
           $(this).addClass("btn-primary");
           $(this).addClass("text-white");
         break;
         case "copiar":
           $(this).attr("title",$(this).html());
           $(this).html("<i class='fas fa-fw fa-copy'></i>");
           $(this).addClass("btn-warning");
           $(this).addClass("text-white");
         break;
         case "anular":
           $(this).attr("title",$(this).html());
           $(this).html("<i class='fas fa-fw fa-trash'></i>");
           $(this).addClass("btn-danger");
           $(this).addClass("text-white");
         break;
         case "&lt;--anterior":
           $(this).attr("title",$(this).html());
           $(this).html("<i class='fas fa-fw fa-arrow-left'></i> ANTERIOR");
           $(this).addClass("btn-info");
           $(this).addClass("text-white");
         break;
         case "siguiente--&gt;":
           $(this).attr("title",$(this).html());
           $(this).html("SIGUIENTE <i class='fas fa-fw fa-arrow-right'></i>");
           $(this).addClass("btn-info");
           $(this).addClass("text-white");
         break;
         default:
           $(this).attr("title",$(this).html());
           $(this).addClass("btn-link");
         break;
      }       

  });
   $("table tr td a h3").each( function () {
      $(this).replaceWith("<b>"+$(this).html()+"</b>");
   });

   $('table .titulo_tabla td').each( function () {
   	$(this).replaceWith("<th>"+$(this).text()+"</th>");
  } );

   $('table tr td strong').each( function () {
   	$(this).replaceWith("<label class=''>"+$(this).html()+"</label>");
   });

   $("table tr").removeClass("titulo_tabla");	
	 $("#resultados table tr td").attr("style","font-size:9px !important;");


   //buscar titulos o etiquetas th
   $("table tr th").each( function () {
      switch($(this).html().toLowerCase().trim()){
         case "¡no existen registros!":
           $(this).html("<center><h5>No se encontró ningún dato</h5></center>");
           $(this).addClass("text-success");
         break; 
         default:
           
         break;
      }
  });
   
  /* $("#cotizacion tr td").each( function () {
    var cantidad =  $(this).attr("colspan");
    //alert(cantidad);
    for (var i = 1; i < parseInt(cantidad); i++) {
       $(this).after("<td class='d-none'></td>");
    };
  });
   $("#cotizacion").DataTable();*/
}

$(document).ready(function() {
  /*if($("#resultados").length>0){
    $("#resultados").html('<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-success">LISTADO</h6></div>'+$("#resultados").html());
   }*/
	cargarClasesFrame();
  setInterval('cargarClasesFrame()',1000);
	$("body").attr("style","visibility:visible !important;background:none;");
});