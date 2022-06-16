function modalNuevoTimeline(){
	$("#nombreTimeline").val("")
	$("#descripcionTimeline").val("")
	$('#modalNuevoTimeline').modal('show');
}

function nuevoTimeline(){
	var errores=new Array();
	if($("#nombreTimeline").val().length<4){
		errores.push("Completa el nombre del timeline");
	}
	if(errores.length==0 && !$("#nuevoTimeline").hasClass("disabled")){
		$("#nuevoTimeline").html("Creando...");
		$("#nuevoTimeline").addClass("disabled");
		var params=new Object();
		params.action="createTimeline";
		params.Nombre=$("#nombreTimeline").val();
		params.Descripcion=$("#descripcionTimeline").val();
		$.post("backend",params,function(resp){
			show_toast("Crear timeline","Timeline creado!");
			$("#nuevoTimeline").html("Crear");
			$("#nuevoTimeline").removeClass("disabled");
			$('#modalNuevoTimeline').modal('toggle');
			window.location.reload();
		},"json")
		.fail(function(){
			show_toast("Crear timeline","Ocurrió un error al crear el timeline");
		})
	}else{
		show_toast("Crear timeline",errores.join(", "));
	}
}