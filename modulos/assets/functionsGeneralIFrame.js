
function cargarClasesFrame(){
   $(":text").addClass("form-control");
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
      $(this).attr("title",$(this).html());
      $(this).addClass("btn");
      $(this).addClass("btn-sm");

      switch($(this).html().toLowerCase().trim()){
         case "detalle":
           $(this).html("<i class='fas fa-fw fa-reorder'></i>");
           $(this).addClass("btn-warning");
           $(this).addClass("text-white");
         break;
         case "editar":
           $(this).html("<i class='fas fa-fw fa-edit'></i>");
           $(this).addClass("btn-primary");
           $(this).addClass("text-white");
         break;
         case "copiar":
           $(this).html("<i class='fas fa-fw fa-copy'></i>");
           $(this).addClass("btn-warning");
           $(this).addClass("text-white");
         break;
         case "anular":
           $(this).html("<i class='fas fa-fw fa-trash'></i>");
           $(this).addClass("btn-danger");
           $(this).addClass("text-white");
         break;
         case "&lt;--anterior":
           $(this).html("<i class='fas fa-fw fa-arrow-left'></i> ANTERIOR");
           $(this).addClass("btn-info");
           $(this).addClass("text-white");
         break;
         case "siguiente--&gt;":
           $(this).html("SIGUIENTE <i class='fas fa-fw fa-arrow-right'></i>");
           $(this).addClass("btn-info");
           $(this).addClass("text-white");
         break;
         default:
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

   	
}

$(document).ready(function() {
	cargarClasesFrame();
	$("body").attr("style","visibility:visible !important;background:none;");
});