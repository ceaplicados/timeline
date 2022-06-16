var toastObj
$(document).ready(function(){
	checarSesion();
	toastObj=$('#toastList .toast').clone();
	$('#toastList').html("")
})


function show_toast(titulo,texto){
	var clonedToast=$("#toastList").append(toastObj.clone());
	clonedToast.find(".mr-auto").html(titulo);
	clonedToast.find(".toast-body").html(texto);
	clonedToast.find(".toast").toast('show').on('hidden.bs.toast', function () {
		$(this).remove();
	})
}

function checarSesion(){
	var params=new Object();
	params.action="checarSesion";
	$.post("/backend",params,function(resp){
		if(!resp.result){
			window.location.href="/login?noSession";
		}else{
			setTimeout(function(){
				checarSesion()
			},5000);
		}
	},"json")
	.fail(function(){
		window.location.href="/login?failAuth";
	})
}

function toggleSearch(){
	$("#buscadorForm").toggleClass("activo")
}

function mesLetra(mes){
	resp="";
	if(mes=="01"){
		resp="Ene";
	}
	if(mes=="02"){
		resp="Feb";
	}
	if(mes=="03"){
		resp="Mar";
	}
	if(mes=="04"){
		resp="Abr";
	}
	if(mes=="05"){
		resp="May";
	}
	if(mes=="06"){
		resp="Ju ";
	}
	if(mes=="07"){
		resp="Jul";
	}
	if(mes=="08"){
		resp="Ago";
	}
	if(mes=="09"){
		resp="Sep";
	}
	if(mes=="10"){
		resp="Oct";
	}
	if(mes=="11"){
		resp="Nov";
	}
	if(mes=="12"){
		resp="Dic";
	}
	return resp;
}

function validateURL(url){
	var re = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;
	return re.test(url);
}