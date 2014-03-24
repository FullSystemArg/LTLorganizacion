$(function() {
    $('.changeprice').change(function(){
    	var categoria 	= $('#id_category').val();
    	var socio 		= $('#socio').val();
    	var total 		= '';

    	if(categoria != '' && socio != ''){
    		$.ajax({
    			type	: "POST",
    			url		: "check_price_category_socio.php",
    			data	: "categoria="+categoria+"&socio="+socio,
    			cache	: false,
    			success : function(r){
    						$('.costo').html('Costo de la Inscripción: <b>$'+r+'</b>')
    					}
    		});
    	}
    	
    });
});

function validar_pw(){
	var pw 	= $('#password').val();
	var pw2 = $('#password2').val();

	if (pw.length <= 5){
		alert("ERROR: La password debe tener como mínimo 6 caracteres.");
		return false;	
	}


	if(pw != pw2){
		alert("ERROR: Los passwords ingresados no coinciden.");
		return false;
	}
	return true;
}

function validar_ticket(){
    var ticket  = $('#ticket').val();

    if(ticket == ''){
        alert("ERROR: Debes ingresar el archivo del Ticket.");
        return false;
    }
    return true;
}

function validar_file(){
    var file  = $('#file').val();

    if(file == ''){
        alert("ERROR: Debes ingresar un archivo.");
        return false;
    }
    return true;
}

function deleteFile(id){
    var r = confirm("Seguro que desea Eliminar este archivo?");
    if (r == true){
        $.ajax({
            type    : "GET",
            url     : "file_del.php",
            data    : {id_file: id},
            cache   : false,
            success : function(r){
                        $("#file_"+id).hide("slow");
                        $("iframe", parent.document).height( $("iframe", parent.document).height() - 20);
                    }
        });
    }else{
        return false;
    }   
}

function logout(){
    var r = confirm("Esta seguro que desea salir del Panel de Usuario?")
    if (r==true){
        $.get('logout_panel_usuario.php', function(data) {
            document.location.href = "congreso-micologia.php";
        });
    }
    return false;
}
