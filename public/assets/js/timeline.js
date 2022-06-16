var Timeline, Suceso;
$(document).ready(function(){
	$("#interface").addClass("loaded");
	setTimeout(function(){
		refreshTimeline();
	},2000);
	$("#detalleSuceso ul.tabSelector li").click(function(){
		$("#detalleSuceso ul.tabSelector li").each(function(){
			$("#detalleSuceso").removeClass($(this).attr("data-target"));
		})
		$("#detalleSuceso").addClass($(this).attr("data-target"));
	});
	setInterval(function(){
		reacomodarSucesos();
	},20);
	$("body").append('<script type="text/javascript" src="https://apis.google.com/js/api.js?onload=onGApiLoad"></script>');
})

function refreshTimeline(){
	var params=new Object();
	params.action="getFullTimeline";
	params.Timeline=$("#timeline_nonce").val();
	$.post("/backend",params,function(resp){
		Timeline=resp;
		if(Timeline.Nombre!==$("h1").text()){
			$("h1").html(Timeline.Nombre);
		}
		if(Timeline.fechaMin){
			var fechaFin;
			var fechaMin;
			if(resp.fechaMin){
				fechaMin=Timeline.fechaMin.substring(0,4);
			}
			if(resp.fechaMax){
				fechaFin=Timeline.fechaMax.substring(0,4);
			}
			if(fechaMin==fechaFin){
				fechaMin=mesLetra(Timeline.fechaMin.substring(5,7))+" "+Timeline.fechaMin.substring(0,4);
				fechaFin=mesLetra(Timeline.fechaMax.substring(5,7))+" "+Timeline.fechaMax.substring(0,4);
			}
			if($("#fechaIni").text()!==fechaMin){
				$("#fechaIni").html(fechaMin+'<span></span>');
			}
			if($("#fechaIni").hasClass("oculto")){
				$("#fechaIni").removeClass("oculto")
			}
			if(fechaFin){
				if($("#fechaFin").text()!==fechaFin){
					$("#fechaFin").html(fechaFin+'<span></span>');
				}
				if($("#fechaFin").hasClass("oculto")){
					$("#fechaFin").removeClass("oculto")
				}
			}
			if($("#timeline").attr("data-fechaMin")!==Timeline.fechaMin){
				$("#timeline").attr("data-fechaMin",Timeline.fechaMin);
			}
			if($("#timeline").attr("data-fechaMax")!==Timeline.fechaMax){
				$("#timeline").attr("data-fechaMax",Timeline.fechaMax);
			}
		}
		var reacomodar=false;
		for (let i = 0; i < resp.Sucesos.length; i++) {
			if($(".suceso[data-id='"+resp.Sucesos[i].Id+"']").length==0){
				var fecha="";
				var fechaDetalle="";
				var anioIni=resp.Sucesos[i].FechaIni.substring(0,4);
				var mesIni=resp.Sucesos[i].FechaIni.substring(5,7);
				if(resp.Sucesos[i].NivelDetalleFechaIni=="anio"){
					fecha=resp.Sucesos[i].FechaIni.substring(0,4);
					fechaDetalle=resp.Sucesos[i].FechaIni.substring(0,4);
				}
				if(resp.Sucesos[i].NivelDetalleFechaIni=="mes"){
					fecha=mesLetra(resp.Sucesos[i].FechaIni.substring(5,7))+" "+resp.Sucesos[i].FechaIni.substring(0,4);
					fechaDetalle=mesLetra(resp.Sucesos[i].FechaIni.substring(5,7))+" "+resp.Sucesos[i].FechaIni.substring(0,4);
				}
				if(resp.Sucesos[i].NivelDetalleFechaIni=="dia"){
					fechaDetalle=mesLetra(resp.Sucesos[i].FechaIni.substring(5,7))+" "+parseInt(resp.Sucesos[i].FechaIni.substring(8,10))+resp.Sucesos[i].FechaIni.substring(0,4);
				}
				fechaFin=resp.Sucesos[i].FechaFin;
				nivelDetalleFechaFin=resp.Sucesos[i].NivelDetalleFechaFin;
				if(resp.Sucesos[i].FechaFin2){
					fechaFin=resp.Sucesos[i].FechaFin2;
					nivelDetalleFechaFin=resp.Sucesos[i].NivelDetalleFechaFin2;
				}
				if(nivelDetalleFechaFin=="anio"){
					if(anioIni!==fechaFin.substring(0,4)){
						fecha+=" - "+fechaFin.substring(0,4);
						fechaDetalle=fecha;
					}
				}
				if(nivelDetalleFechaFin=="mes"){
					if(anioIni==fechaFin.substring(0,4)){
						fecha=mesLetra(mesIni)+" - "+mesLetra(fechaFin.substring(5,7))+" "+fechaFin.substring(0,4);
						fechaDetalle=fecha;
					}else{
						fecha+=" - "+mesLetra(fechaFin.substring(5,7))+" "+fechaFin.substring(0,4);
						fechaDetalle=fecha;
					}
				}
				if(nivelDetalleFechaFin=="dia"){
					fechaDetalle+=" - "+mesLetra(fechaFin.substring(5,7))+" "+parseInt(fechaFin.substring(8,10))+fechaFin.substring(0,4);
				}
				fechaFin=resp.Sucesos[i].FechaFin;
				if(resp.Sucesos[i].FechaFin2){
					fechaFin=resp.Sucesos[i].FechaFin2;
				}
				var fechaIni=new Date(resp.Sucesos[i].FechaIni);
				var fechaFin=new Date(fechaFin);
				var fechaPromedio=new Date((fechaIni.getTime()+fechaFin.getTime())/2);
				fechaPromedio=fechaPromedio.toISOString().replace("T"," ").substring(0,10);
				
				$("#timeline").append('<div class="suceso oculto" data-id="'+resp.Sucesos[i].Id+'" data-fechaRef="'+fechaPromedio+'"  onclick="toogleSuceso(this)"><span class="nombre">'+resp.Sucesos[i].Nombre+'</span><span class="descripcion">'+resp.Sucesos[i].Descripcion+'</span><span class="fecha">'+fecha+'</span><span class="fechaDetalle">'+fechaDetalle+'</span><span class="detalle"></span><div class="linea"></div></div>');
				reacomodar=true;
			}
		}
		if($("#detalleSuceso").hasClass("shown")){
			var Suceso;
			for (i = 0; i < Timeline.Sucesos.length; i++) {
			  if(Timeline.Sucesos[i].Id==$("#detalleSuceso").attr("data-id")){
				Suceso=Timeline.Sucesos[i];
			  }
			}
			if($("#detalleSuceso .nombreSuceso").text()!==Suceso.Nombre){
				$("#detalleSuceso .nombreSuceso").html(Suceso.Nombre);
			}
			if($("#detalleSuceso p.descripcion").text()!==Suceso.Descripcion){
				$("#detalleSuceso p.descripcion").html(Suceso.Descripcion);
			}
			for (let i = 0; i < Suceso.Ligas.length; i++) {
				if($("#detalleSuceso .ligas li[data-id='"+Suceso.Ligas[i].Id+"']").length==0){
					imagen="";
					if(Suceso.Ligas[i].Imagen){
						imagen='<img src="'+Suceso.Ligas[i].Imagen+'"/>';
					}
					$("#detalleSuceso .ligas").append('<li data-id="'+Suceso.Ligas[i].Id+'"><span class="titulo">'+Suceso.Ligas[i].Title+'</span><span class="descripcion">'+Suceso.Ligas[i].Descripcion+'</span><i class="fas fa-edit" onclick="modalLiga(this)"></i><a href="'+Suceso.Ligas[i].URL+'" target="_blank"><i class="fas fa-link"></i></a><div class="imagen">'+imagen+'</div></li>');
				}
			}
			$("#detalleSuceso .tabSelector li[data-target='ligasSuceso']").html("Ligas <b>("+Suceso.Ligas.length+")</b>");
			for (let i = 0; i < Suceso.Notas.length; i++) {
				if($("#detalleSuceso .listaNotas .nota[data-id='"+Suceso.Notas[i].Id+"']").length==0){
					var style=new Array();
					var texto="";
					if(Suceso.Notas[i].Nota){
						texto=Suceso.Notas[i].Nota;
					}
					if(Suceso.Notas[i].CSS){
						if(Suceso.Notas[i].CSS.left){
							style.push("left:"+(Suceso.Notas[i].CSS.left*$("#detalleSuceso .listaNotas").width())+"px");
						}
						if(Suceso.Notas[i].CSS.top){
							style.push("top:"+(Suceso.Notas[i].CSS.top*$("#detalleSuceso").height()-$("#detalleSuceso .listaNotas").position().top)+"px");
						}
					}
					$("#detalleSuceso .listaNotas").prepend('<div class="nota" style="'+style.join(";")+'" data-id="'+Suceso.Notas[i].Id+'"><div class="content" contenteditable="true">'+texto+'</div></div>');
				}
			}
			$("#detalleSuceso .tabSelector li[data-target='notasSuceso']").html("Notas <b>("+Suceso.Notas.length+")</b>");
			$("#detalleSuceso .listaNotas .nota").draggable({
				  cancel: ".content",
				  stop: function( event, ui ) {
					  saveCSSNota($(this));
				  }
				});
			$("#detalleSuceso .listaNotas .nota").find(".content").blur(function(){
				if($(this).text().trim().length>0){
					saveTextoNota($(this));
				}
			})
			$("#detalleSuceso .tabSelector li[data-target='googleDrive']").html("Archivos en Drive <b>("+Suceso.Archivos.length+")</b>");
			for (let i = 0; i < Suceso.Archivos.length; i++) {
				if($("#detalleSuceso #googleDrive .archivos li[data-id='"+Suceso.Archivos[i].Id+"']").length==0){
					$("#detalleSuceso #googleDrive .archivos").append('<li data-id="'+Suceso.Archivos[i].Id+'"><span class="nombre"><img src="'+Suceso.Archivos[i].Icon+'">'+Suceso.Archivos[i].Nombre+'</span><a target="_blank" href="'+Suceso.Archivos[i].URL+'"><i class="fas fa-external-link-alt"></i></a></li>');
				}
			}
			
		}
		if(reacomodar){
			reacomodarSucesos();
		}
	},"json");
	setTimeout(function(){
		refreshTimeline()
	},2000);
}

function toogleSuceso(Obj){
	$("#timeline .suceso").removeClass("open");
	$(Obj).toggleClass("open");
	for (let i = 0; i < Timeline.Sucesos.length; i++) {
		if(Timeline.Sucesos[i].Id==$(Obj).attr("data-id")){
			Suceso=Timeline.Sucesos[i];
		}
	}
	$("#detalleSuceso").attr("data-id",Suceso.Id)
	$("#detalleSuceso .nombreSuceso").html(Suceso.Nombre);
	$("#detalleSuceso .descripcion").html(Suceso.Descripcion);
	$("#detalleSuceso ul.tabSelector li").each(function(){
		$("#detalleSuceso").removeClass($(this).attr("data-target"));
	})
	$("#detalleSuceso").addClass("notasSuceso");
	$("#detalleSuceso .ligas").html("");
	$("#detalleSuceso .listaNotas").html("");
	$("#detalleSuceso .tabSelector li[data-target='notasSuceso']").html("Notas");
	$("#detalleSuceso .tabSelector li[data-target='ligasSuceso']").html("Ligas");
	$("#detalleSuceso .tabSelector li[data-target='googleDrive']").html("Archivos en Drive");
	$("#detalleSuceso #googleDrive .archivos").html("");
	$("#detalleSuceso").addClass("shown");
}
function cerrarSuceso(){
	$("#detalleSuceso").removeClass("shown");
	$("#timeline .suceso").removeClass("open");
}

function reacomodarSucesos(){
	var arraySucesos=new Array();
	fechaMin=new Date($("#timeline").attr("data-fechaMin"));
	fechaMax=new Date($("#timeline").attr("data-fechaMax"));
	tiempoTotal=fechaMax.getTime()-fechaMin.getTime();
	maxWidth=$("#timeline").width();
	$("#timeline .suceso").each(function(){
		fecha=new Date($(this).attr("data-fechaRef"));
		posX=fecha.getTime()-fechaMin.getTime();
		posX=posX/tiempoTotal*maxWidth-$(this).width()/2;
		if(posX<10){
			posX=10;
		}
		if((posX+$(this).width())>maxWidth){
			posX=maxWidth-$(this).width()-30;
		}
		if(($(this).position().top+$(this).height())>0){
			$(this).css("bottom","unset");
			$(this).css("top",(0-$(this).height()-40)+"px");
		}
		var empalme=false;
		do{
			for (let i = 0; i < arraySucesos.length; i++) {
				rect1=arraySucesos[i];
				rect2={x: $(this).position().left, y: $(this).position().top, width: $(this).width(), height: $(this).height()};
				if (rect1.x < rect2.x + rect2.width &&
				   rect1.x + rect1.width > rect2.x &&
				   rect1.y < rect2.y + rect2.height &&
				   rect1.y + rect1.height > rect2.y) {
					   empalme=true;
				}
			}
			if(empalme){
				$(this).css("bottom","unset");
				newTop=$(this).position().top-50;
				$(this).css("top",newTop+"px");
				if($(this).position().top<0){
					$(this).css("top",newTop+"px");
					empalme=false;
				}
			}
		}while(empalme);
		arraySucesos.push({x: $(this).position().left, y: $(this).position().top, width: $(this).width(), height: $(this).height()});
		$(this).css("left",posX+"px");
		if($(this).hasClass("oculto")){
			$(this).removeClass("oculto")
		}
	})
}

function modalSuceso(Obj){
	$("#modalSuceso .modal-title").html("Nuevo suceso");
	$("#modalSuceso").attr("data-id","");
	$("#nombreSuceso").val("");
	$("#rangoFechaInicial").prop("checked",false);
	$("#anioFechaIni").val("");
	$("#anioFechaIni1").val("");
	$("#mesFechaIni option[value='00']").prop("selected",true);
	$("#mesFechaIni1 option[value='00']").prop("selected",true);
	$("#diaFechaIni").val("");
	$("#diaFechaIni1").val("");
	toggleRangoFechaIni();
	$("#rangoFechaFinal").prop("checked",false);
	$("#anioFechaFin").val("");
	$("#anioFechaFin1").val("");
	$("#mesFechaFin option[value='00']").prop("selected",true);
	$("#mesFechaFin1 option[value='00']").prop("selected",true);
	$("#diaFechaFin").val("");
	$("#diaFechaFin1").val("");
	toggleRangoFechaFin();
	$("#descripcionSuceso").val("");
	$("#guardarSuceso").html("Crear");
	if(Obj){
		$("#modalSuceso .modal-title").html("Editar suceso");
		$("#modalSuceso").attr("data-id",Suceso.Id);
		$("#nombreSuceso").val(Suceso.Nombre);
		$("#anioFechaIni").val(Suceso.FechaIni.substring(0,4));
		if(Suceso.NivelDetalleFechaIni!=="anio"){
			$("#mesFechaIni option[value='"+Suceso.FechaIni.substring(5,7)+"']").prop("selected",true);
			if(Suceso.NivelDetalleFechaIni=="dia"){
				$("#diaFechaIni").val(Suceso.FechaIni.substring(8,10));
			}
		}
		if(Suceso.FechaIni2){
			$("#rangoFechaInicial").prop("checked",true);
			$("#anioFechaIni1").val(Suceso.FechaIni2.substring(0,4));
			if(Suceso.NivelDetalleFechaIni2!=="anio"){
				$("#mesFechaIni1 option[value='"+Suceso.FechaIni2.substring(5,7)+"']").prop("selected",true);
				if(Suceso.NivelDetalleFechaIni2=="dia"){
					$("#diaFechaIni1").val(Suceso.FechaIni2.substring(8,10));
				}
			}
		}
		$("#anioFechaFin").val(Suceso.FechaFin.substring(0,4));
		if(Suceso.NivelDetalleFechaFin!=="anio"){
			$("#mesFechaFin option[value='"+Suceso.FechaFin.substring(5,7)+"']").prop("selected",true);
			if(Suceso.NivelDetalleFechaFin=="dia"){
				$("#diaFechaFin").val(Suceso.FechaFin.substring(8,10));
			}
		}
		toggleRangoFechaIni();
		if(Suceso.FechaFin2){
			$("#rangoFechaFinal").prop("checked",true);
			$("#anioFechaFin1").val(Suceso.FechaFin2.substring(0,4));
			if(Suceso.NivelDetalleFechaFin2!=="anio"){
				$("#mesFechaFin1 option[value='"+Suceso.FechaFin2.substring(5,7)+"']").prop("selected",true);
				if(Suceso.NivelDetalleFechaFin2=="dia"){
					$("#diaFechaFin1").val(Suceso.FechaFin2.substring(8,10));
				}
			}
		}
		toggleRangoFechaFin();
		$("#descripcionSuceso").val(Suceso.Descripcion);
		$("#guardarSuceso").html("Actualizar");
	}
	$("#guardarSuceso").removeClass("disabled");
	$("#modalSuceso").modal("toggle");
}

function toggleRangoFechaIni(){
	if($("#rangoFechaInicial").is(":checked")){
		$("#modalSuceso .rangoFechaIni").show()
		$("#modalSuceso .exactaFechaIni").hide()
	}else{
		$("#modalSuceso .rangoFechaIni").hide()
		$("#modalSuceso .exactaFechaIni").show()
	}
}
function toggleRangoFechaFin(){
	if($("#rangoFechaFinal").is(":checked")){
		$("#modalSuceso .rangoFechaFin").show()
		$("#modalSuceso .exactaFechaFin").hide()
	}else{
		$("#modalSuceso .rangoFechaFin").hide()
		$("#modalSuceso .exactaFechaFin").show()
	}
}

function guardarSuceso(){
	var errores=new Array();
	if($("#nombreSuceso").val().length<3){
		errores.push("Nombre del suceso")
	}
	if($("#rangoFechaInicial").is(":checked")){
		if($("#anioFechaIni").val().length<1){
			errores.push("Año inicial del periodo de inicio");
		}
		if($("#anioFechaIni1").val().length<1){
			errores.push("Año final del periodo de inicio");
		}
	}else{
		if($("#anioFechaIni").val().length<1){
			errores.push("Año de inicio");
		}
	}
	if($("#rangoFechaFinal").is(":checked")){
		if($("#anioFechaFin").val().length<1){
			errores.push("Año inicial del periodo de fin");
		}
		if($("#anioFechaFin1").val().length<1){
			errores.push("Año final del periodo de fin");
		}
	}else{
		if($("#anioFechaFin").val().length<1){
			errores.push("Año de fin");
		}
	}
	if(!$("#nuevoTimeline").hasClass("disabled")){
		if(errores.length>0){
			alert("Corrige la siguiente información: "+errores.join(", "));
		}else{
			$("#guardarSuceso").html("Guardando...");
			$("#guardarSuceso").addClass("disabled");
			var params=new Object();
			params.action="guardarSuceso";
			params.Id=$("#modalSuceso").attr("data-id");
			params.Timeline=$("#timeline_nonce").val()
			params.Nombre=$("#nombreSuceso").val();
			params.Descripcion=$("#descripcionSuceso").val();
			params.AnioFechaIni=$("#anioFechaIni").val();
			params.MesFechaIni=$("#mesFechaIni").val();
			params.DiaFechaIni=$("#diaFechaIni").val();
			params.RangoFechaIni=0;
			if($("#rangoFechaInicial").is(":checked")){
				params.RangoFechaIni=1;
				params.AnioFechaIni1=$("#anioFechaIni1").val();
				params.MesFechaIni1=$("#mesFechaIni1").val();
				params.DiaFechaIni1=$("#diaFechaIni1").val();
			}
			params.AnioFechaFin=$("#anioFechaFin").val();
			params.MesFechaFin=$("#mesFechaFin").val();
			params.DiaFechaFin=$("#diaFechaFin").val();
			params.RangoFechaFin=0;
			if($("#rangoFechaFinal").is(":checked")){
				params.RangoFechaFin=1;
				params.AnioFechaFin1=$("#anioFechaFin1").val();
				params.MesFechaFin1=$("#mesFechaFin1").val();
				params.DiaFechaFin1=$("#diaFechaFin1").val();
			}
			$.post("/backend",params,function(resp){
				$("#modalSuceso").modal("toggle");
			},"json")
			.fail(function(){
				alert("Algo salió mal y no se pudo guardar el suceso.");
			});
		}
	}
}

function modalLiga(Obj){
	$("#modalLiga .modal-title").html("Añadir liga de referencia");
	$("#modalLiga").attr("data-id","");
	$("#urlLiga").val("");
	$("#tituloLiga").val("");
	$("#imagenLiga").html("");
	$("#descripcionLiga").val("");
	$("#anioFechaNota").val("");
	$("#mesFechaNota option[value='01']").prop("selected",true);
	$("#diaFechaNota").val("");
	$("#anioFechaIniLiga").val("");
	$("#mesFechaIniLiga option[value='00']").prop("selected",true);
	$("#diaFechaIniLiga").val("");
	$("#anioFechaFinLiga").val("");
	$("#mesFechaFinLiga option[value='00']").prop("selected",true);
	$("#diaFechaFinLiga").val("");
	$("#guardarLiga").html("Añadir");
	if(Obj){
		var Liga;
		for (let i = 0; i < Suceso.Ligas.length; i++) {
			if(Suceso.Ligas[i].Id==$(Obj).closest("li").attr("data-id")){
				Liga=Suceso.Ligas[i];
			}
		}
		if(Liga.Id){
			$("#modalLiga .modal-title").html("Editar liga de referencia");
			$("#modalLiga").attr("data-id",Liga.Id);
			$("#urlLiga").val(Liga.URL);
			$("#tituloLiga").val(Liga.Title);
			if(Liga.Imagen){
				$("#imagenLiga").html('<img src="'+Liga.Imagen+'">');	
			}
			$("#descripcionLiga").val(Liga.Descripcion);
			$("#anioFechaNota").val(Liga.FechaPublicacion.substring(0,4));
			$("#mesFechaNota option[value='"+Liga.FechaPublicacion.substring(5,2)+"']").prop("selected",true);
			$("#diaFechaNota").val(Liga.FechaPublicacion.substring(8,10));
			$("#anioFechaIniLiga").val(Liga.FechaIni.substring(0,4));
			$("#mesFechaIniLiga option[value='"+Liga.FechaIni.substring(5,2)+"']").prop("selected",true);
			if(Liga.FechaIni.substring(8,10)!=="00"){
				$("#diaFechaIniLiga").val(Liga.FechaIni.substring(8,10));
			}
			if(Liga.FechaFin){
				$("#anioFechaFinLiga").val(Liga.FechaFin.substring(0,4));
				$("#mesFechaFinLiga option[value='"+Liga.FechaFin.substring(5,7)+"']").prop("selected",true);
				if(Liga.FechaFin.substring(8,10)!=="00"){
					$("#diaFechaFinLiga").val(Liga.FechaFin.substring(8,10));
				}
			}
			$("#guardarLiga").html("Guardar");
			$("#guardarLiga").removeClass("disabled");
			$("#modalLiga").modal("toggle");
		}
	}else{
		$("#guardarLiga").removeClass("disabled");
		$("#modalLiga").modal("toggle");
	}
	
}

function do_extraerLiga(){
	if(!$("#extraerLiga").hasClass("disabled")){
		if(validateURL($("#urlLiga").val())){
			$("#extraerLiga").addClass("disabled");
			$("#extraerLiga").html("Extrayendo...");
			var params=new Object();
			params.action="extraerLiga";
			params.URL=$("#urlLiga").val();
			$.post("/backend?liga",params,function(resp){
				$("#urlLiga").val(resp.url)
				$("#tituloLiga").val(resp.title);
				$("#descripcionLiga").val(resp.description);
				if(resp.image){
					$("#imagenLiga").html('<img src="'+resp.image+'">');
				}
				if(resp.published_date){
					$("#anioFechaNota").val(resp.published_date.substring(0,4));
					$("#mesFechaNota option[value='"+resp.published_date.substring(5,7)+"']").prop("selected",true);
					$("#diaFechaNota").val(resp.published_date.substring(8,10));
					if($("#anioFechaIniLiga").val().length==0){
						$("#anioFechaIniLiga").val(resp.published_date.substring(0,4));
					}
					if($("#anioFechaFinLiga").val().length==0){
						$("#anioFechaFinLiga").val(resp.published_date.substring(0,4));
					}
					if($("#mesFechaIniLiga").val()=="00"){
						$("#mesFechaIniLiga option[value='"+resp.published_date.substring(5,7)+"']").prop("selected",true);
					}
					if($("#mesFechaFinLiga").val()=="00"){
						$("#mesFechaFinLiga option[value='"+resp.published_date.substring(5,7)+"']").prop("selected",true);
					}
					if($("#diaFechaIniLiga").val().length==0){
						$("#diaFechaIniLiga").val(resp.published_date.substring(8,10));
					}
					if($("#diaFechaFinLiga").val().length==0){
						$("#diaFechaFinLiga").val(resp.published_date.substring(8,10));
					}
					
				}
				$("#extraerLiga").removeClass("disabled");
				$("#extraerLiga").html("Extraer liga");
			},"json")
		}else{
			alert("Ingresa una URL válida");
		}
		
	}
}

function guardarLiga(){
	if(!$("#guardarLiga").hasClass("disabled")){
		var errores=new Array();
		if(!validateURL($("#urlLiga").val())){
			errores.push("URL incorrecta");
		}
		if($("#tituloLiga").val().length<3){
			errores.push("Añade un título");
		}
		if($("#anioFechaIniLiga").val().length<3){
			errores.push("Fecha de inicio del periodo de referencia");
		}
		if(errores.length==0){
			$("#guardarLiga").addClass("disabled");
			$("#guardarLiga").html("Guardando...");
			var params=new Object();
			params.action="guardarLiga";
			params.Id=$("#modalLiga").attr("data-id");
			params.Suceso=$("#detalleSuceso").attr("data-id");
			params.URL=$("#urlLiga").val();
			params.Titulo=$("#tituloLiga").val();
			params.Descripcion=$("#descripcionLiga").val();
			if($("#imagenLiga img")){
				params.Imagen=$("#imagenLiga img").attr("src");
			}
			params.AnioFechaNota=$("#anioFechaNota").val();
			params.MesFechaNota=$("#mesFechaNota").val();
			params.DiaFechaNota=$("#diaFechaNota").val();
			params.AnioFechaIni=$("#anioFechaIniLiga").val();
			params.MesFechaIni=$("#mesFechaIniLiga").val();
			params.DiaFechaIni=$("#diaFechaIniLiga").val();
			params.AnioFechaFin=$("#anioFechaFinLiga").val();
			params.MesFechaFin=$("#mesFechaFinLiga").val();
			params.DiaFechaFin=$("#diaFechaFinLiga").val();
			$.post("/backend",params,function(resp){
				$("#modalLiga").modal("toggle");
				$("#guardarLiga").removeClass("disabled");
				$("#guardarLiga").html("Guardar");
				$("#ligasSuceso .ligas li[data-id='"+resp.Id+"']").remove();
			},"json")
		}else{
			alert("Corrige los siguientes errores: "+errores.join(", "));
		}
	}
}

function addNota(){
	var iniPos=$("#detalleSuceso .listaNotas .nota").length*50;
	$("#detalleSuceso .listaNotas").prepend('<div class="nota" style="left:'+iniPos+'px;top:'+iniPos+'px;" data-id=""><div class="content" contenteditable="true"></div></div>');
	$("#detalleSuceso .listaNotas .nota").each(function(){
		if(!$(this).hasClass("ui-draggable")){
			$(this).draggable({
				  cancel: ".content",
				  stop: function( event, ui ) {
					  saveCSSNota($(this));
				  }
				});
			$(this).find(".content").blur(function(){
				if($(this).text().trim().length>0){
					saveTextoNota($(this));
				}
			})
		}
	});
}

function saveCSSNota(Obj){
	if(!$(Obj).closest(".nota").hasClass("guardando")){
		$(Obj).closest(".nota").addClass("guardando");
		var params=new Object();
		  params.action="guardarCSSNota";
		  params.Id=$(Obj).closest(".nota").attr("data-id");
		  params.Suceso=$("#detalleSuceso").attr("data-id");
		  params.Estilos=new Object();
		  params.Estilos.left=$(Obj).position().left/$("#detalleSuceso .listaNotas").width();
		  params.Estilos.top=($(Obj).position().top+$("#detalleSuceso .listaNotas").position().top)/$("#detalleSuceso").height();
		  $.post("/backend",params,function(resp){
			  if($(Obj).closest(".nota").attr("data-id")!==resp.Id){
				  $(Obj).closest(".nota").attr("data-id",resp.Id);
			  }
			  $(Obj).closest(".nota").removeClass("guardando");
		  },"json")
		  .fail(function(){
			  alert("Sucedió un error al guardar la nota");
		  });
  	}
}
function saveTextoNota(Obj){
	if(!$(Obj).closest(".nota").hasClass("guardando")){
		$(Obj).closest(".nota").addClass("guardando");
		var params=new Object();
		params.action="guardarTextoNota";
		params.Id=$(Obj).closest(".nota").attr("data-id");
		params.Suceso=$("#detalleSuceso").attr("data-id");
		params.Texto=$(Obj).text();
		$.post("/backend",params,function(resp){
			if($(Obj).closest(".nota").attr("data-id")!==resp.Id){
				$(Obj).closest(".nota").attr("data-id",resp.Id);
			}
			$(Obj).closest(".nota").removeClass("guardando");
			if(resp.Nota){
				if(resp.Nota!==$(Obj).text()){
					saveTextoNota(Obj);
				}
			}else if($(Obj).text().trim().length>0){
				saveTextoNota(Obj);
			}
			
		},"json")
		.fail(function(){
			alert("Sucedió un error al guardar la nota");
		});
	}
}

var developerKey = 'AIzaSyBKH78xHUD_N4iLGxO6pdCO8QmuUbqxUOA';
var clientId = "1037180436791-hi54gdeo9ftsfu65rbv6gv03h4thvr1n.apps.googleusercontent.com";
var appId = "1037180436791";
var scope = ['https://www.googleapis.com/auth/drive.file'];
var pickerApiLoaded = false;
var oauthToken = false;
var drivePicker;

function onGApiLoad() {
	gapi.load('auth2');
	gapi.load('picker');
}

function onGAuthApiLoad() {
  window.gapi.auth2.authorize(
	  {
		'client_id': clientId,
		'scope': scope,
		'immediate': false
	  },
	  handleAuthResult);
}
function handleAuthResult(authResult) {
  if (authResult && !authResult.error) {
	oauthToken = authResult.access_token;
	createDrivePicker();
  }
}

function onGPickerApiLoad() {
	pickerApiLoaded = true;
}
function createDrivePicker() {
	if (pickerApiLoaded && oauthToken) {
	  drivePicker = new google.picker.PickerBuilder().
		  addView(google.picker.ViewId.DOCS).
		  //addView(google.picker.ViewId.FOLDERS).
		  //setIncludeFolders(true).
		  setSelectFolderEnabled(true).
		  enableFeature(google.picker.Feature.MULTISELECT_ENABLED).
		  setLocale('es').
		  setOAuthToken(oauthToken).
		  setDeveloperKey(developerKey).
		  setCallback(pickerCallbackDrive).
		  build();
	  drivePicker.setVisible(true);
	}else if(!pickerApiLoaded){
		onGPickerApiLoad();
	}else{
		onGAuthApiLoad();
	}
}

function pickerCallbackDrive(data) {
  if (data.action == google.picker.Action.PICKED) {
	  var params=new Object();
	  params.action="addGoogleDriveFiles";
	  params.Suceso=$("#detalleSuceso").attr("data-id");
	  params.Archivos=new Array();
	  for (i = 0; i < data.docs.length; i++) {
		  var Archivo=new Object();
		  Archivo.url=data.docs[0].url;
		  Archivo.icon=data.docs[0].iconUrl;
		  Archivo.uid=data.docs[0].id;
		  Archivo.mimeType=data.docs[0].mimeType;
		  Archivo.nombre=data.docs[0].name;
		  params.Archivos.push(Archivo);
	  }
	  $.post("/backend",params,function(resp){
		
	  },"json")
  }
}