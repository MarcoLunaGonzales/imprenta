
function cargarClasesFrame(){
   $(":text").addClass("form-control");
   //$("select").addClass("form-control selectpicker");
   $("table").addClass("table");
   $("table").addClass("table-sm");
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