function Ajax(){
	var xmlhttp=false;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
		   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
  		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

var divListado;


//Ordenar la grilla
function f_ordenarPor(campo, orden , pagina, modulo, filtro){
	divListado = document.getElementById(modulo);	
	ajax=Ajax();
	var currentTime = new Date();
	var segundos = currentTime.getSeconds();	
	urls = modulo + "_lis.php?campo="+campo+"&orden="+orden+"&pagina="+pagina+"&filtro="+filtro+"&time="+segundos;
	ajax.open("GET", urls);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			divListado.innerHTML = ajax.responseText;
   	 	    $('#contenido_grilla').jScrollPane({showArrows:true,scrollbarWidth:10, scrollbarMargin:20});			
			//Esta linea las coloco de nuevo aca ya que cuando paso de pag
			//u ordeno no me toma el scroll ya que renueva la pagina con un
			//ajax por lo tanto cuando devuelva la linea de la pag seleccionada
			//se coloca el scroll nuevamente
		}
	}
	ajax.send(null)
}


/* Validaciones de formularios */
function f_validar_customer(){

	var var_first_name 		= document.getElementById("first_name");
	var var_last_name 		= document.getElementById("last_name");
	var var_dni 			= document.getElementById("dni");
	var var_email 			= document.getElementById("email");
	var var_area 			= document.getElementById("id_area");
	var var_category 		= document.getElementById("id_category");
	var var_password 		= document.getElementById("password");
	
	if(var_first_name.value == ''){
		alert("Debe completar el campo: Nombre");
		var_first_name.focus();
		return false;
	}
	if(var_last_name.value == ''){
		alert("Debe completar el campo: Apellido");
		var_last_name.focus();
		return false;
	}
	if(var_dni.value == ''){
		alert("Debe completar el campo: DNI");
		var_dni.focus();
		return false;
	}
	if(var_email.value == ''){
		alert("Debe completar el campo: Email");
		var_email.focus();
		return false;
	}
	if(var_area.value <= 0){
		alert("Debe completar el campo: Area");
		var_area.focus();
		return false;
	}	
	if(var_category.value <= 0){
		alert("Debe completar el campo: Categoria");
		var_category.focus();
		return false;
	}
	if(var_password.value == ''){
		alert("Debe completar el campo: Password");
		var_password.focus();
		return false;
	}
	document.formulario.submit();
}

/* Validaciones de formularios */
function f_validar_file(){
	var var_file = document.getElementById("file");
	
	if(var_file.value == ''){
		alert("Debe completar el campo: Archivo");
		var_file.focus();
		return false;
	}
	
	document.formulario_file.submit();
}

// Login
function f_validar_login(){
	var var_password = document.getElementById("password");
	
	if(var_password.value == ''){
		alert("Debe completar el campo: Password");
		var_password.focus();
		return false;
	}
	
	document.form_login.submit();
}

function f_validar_aconfiguracion(){

	var var_password_ant = document.getElementById("password_ant");
	var var_password = document.getElementById("password");

	if(var_password_ant.value == ''){
		alert("Debe completar el campo: Password anterior");
		var_password_ant.focus();
		return false;
	}
	if(var_password.value == ''){
		alert("Debe completar el campo: Password nuevo");
		var_password.focus();
		return false;
	}
	
	document.formulario.submit();
}


function deleteFile(id){
	var r = confirm("Seguro que desea Eliminar este archivo?");
	if (r == true){

		if($(".valid_box").css("display") == "block"){
			$("iframe", parent.document).height( $("iframe", parent.document).height());	
		}else{
			$("iframe", parent.document).height( $("iframe", parent.document).height() + 55);
		}

		divListado = $("#file_"+id);
		ajax=Ajax();
		var currentTime = new Date();
		var segundos = currentTime.getSeconds();	
		urls = "customer_file_del.php?id="+id+"&time="+segundos;
		ajax.open("GET", urls);
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divListado.hide("slow");
				$(".valid_box").hide();
				$(".error_box").hide();
				$(".warning_box").hide();
							
				$(".msj_ajax").html('<div class="valid_box">Archivo eliminado con &eacute;xito.</div>');

				$('#type').append('<option value="1" selected="selected">Tickets</option>');
				//resizeIframe($("iframe", parent.document));
			}
		}
		ajax.send(null);
	}else{
		return false;
	}	
}
