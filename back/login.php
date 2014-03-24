<?php
require_once("class/functions.class.php");

if(isset($_SESSION['id_users'])){
	header("Location: customer.php");
}

if(isset($_POST['password']) && $_POST['password']!=''){
	$error = $oFunctions->loggin();
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: Administrador ::</title>
<link rel="stylesheet" type="text/css" href="css/style.css" />
<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- Styles -->
<link rel="stylesheet" type="text/css" media="all" href="css/niceforms-default.css" />
<link href="css/style_lis.css" rel="stylesheet" type="text/css" />

<!-- Ajax -->
<script type="text/javascript" src="js/ajax.js"></script>

<script type="text/javascript">
document.onkeydown = f_escapeCheck;
function f_escapeCheck(e){
	if (e == null) { // ie
		  keycode = event.keyCode;
		} else { // mozilla
		  keycode = e.which;
		}
		if (keycode == 13){f_validar_login();}
}
</script>

</head>
<body>
<div id="main_container">

	<div class="header_login">
    <div class="logo">
		
		<!-- <a href="http://mypservicios.com.ar/" style="text-decoration:none"> -->
			<!-- <img src="images/logo.gif" alt="" title="" border="0" /> -->
			<h1 style='cursor: default'>Administrador</h1>
		<!-- </a> -->
	</div>
    
    </div>

     
	<div class="login_form">
		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form_login" id="form_login">			
			<div id="contenido_login">	
				<div id="contenido_login_l">
					<div class="contenedor_campo_login"><label class="titulo">Usuario</label><br />
						<!-- <input type="text" name="username" id="username" class="campo_text" /> -->
						<span style="font-size: 15px; color: #ddd; font-weight: bold"><em>Administrador</em></span>
					</div>										
					<br />
					<div class="contenedor_campo_login"><label class="titulo">Password</label><br /><input type="password" name="password" id="password" class="campo_text" /></div>										

					<div class='contenedor_campo_login'>
						<a href='#' onclick='f_validar_login();' class='bt_black2'><span class='bt_black_lft'></span><strong>Ingresar</strong><span class='bt_black_r'></span></a>
					</div>
					<br /><br />
					<?php
						if(isset($error))echo "<span class='error_login'>{$error}</span>";
					?>
					
				</div>
				<div id="contenido_login_r">
					<img src="images/candado.png"/>
				</div>  			
				<div id="contenido_login_b">
					*Ingrese su Contrase&ntilde;a para poder ingresar al Panel de Administraci&oacute;n de su Sitio.
				</div>		
			</div>  
       
		</form>
	</div>  
	<br />
	
</div>		
</body>
</html>