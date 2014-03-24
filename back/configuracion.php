<?php
require_once("class/configuracion.class.php");
require_once("class/functions.class.php");

$oFunctions->isLoggedIn();

if(isset($_POST["password"]) && $_POST["password"] != '' && isset($_POST["password_ant"]) && $_POST["password_ant"] != ''){
	$password = sha1($_POST["password"]);
	$password_ant = sha1($_POST["password_ant"]);
	
	$comprobar = $oConfiguracion->f_comprobarPw($password_ant);
	if($comprobar == 1)
	{
		$oConfiguracion->f_modificarPw($password);
		header("location: configuracion.php?error=0");
	}else{
		header("location: configuracion.php?error=1");
	}
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html" charset="iso-8859-1" />
<title>:: Administrador | Configuración ::</title>

<!-- Styles -->
<link href="css/style_lis.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!-- Ajax -->
<script type="text/javascript" src="js/ajax.js"></script>

<!-- Ckeditor -->
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<!-- Js -->
<script type="text/javascript" src="js/jquery.min.js"></script>
<script src="js/jquery.jclock-1.2.0.js.txt" type="text/javascript"></script>
<script type="text/javascript" src="js/jconfirmaction.jquery.js"></script>
<script type="text/javascript">	
	$(document).ready(function() {
		$('.ask').jConfirmAction();
	});	
</script>
<script type="text/javascript">
$(function($) {
    $('.jclock').jclock();
});
</script>

</head>
<body>
<div id="main_container">

	<div class="header">
    <div class="logo">
		<a href="index.php" style="text-decoration:none">
			<!-- <img src="images/logo.gif" alt="" title="" border="0" /> -->
			<h1>Panel de Administraci&oacute;n</h1>
		</a>
	</div>
    
	<div class="right_header">
		<div class="jclock"></div>
		<div>
			Bienvenido Admin, <a href="session_delete.php" class="logout">Salir</a>
		</div>
	</div>
    
    
	
	</div>
    
    <div class="main_content">
    
		<div class="menu">
			<ul>
				<li><a href="#">Usuarios</a>
					<ul>
						<li><a href="customer.php" title="">Alta de usuarios</a></li>
					</ul>
				</li>
				
				<li><a href="#">Configuraci&oacute;n</a>
					<ul>
						<li><a href="configuracion.php" title="">Cambiar password</a></li>
					</ul>
				</li>
			</ul>	
		</div> 
                                     
		<div class="center_content"> 
  
			<div class="left_content">			
				<div class="sidebar_search">
					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="form_search" id="form_search">			
						<input type="text" name="defaultb" id="defaultb" class="search_input" value="Ingrese su busqueda" onclick="this.value=''" />
						<input type="image" class="search_submit" src="images/search.png" />
					</form>            
				</div>
		
				<div class="sidebarmenu">
					<a class="menuitem_black" href="customer.php">Usuarios</a>                                
				</div>
				
				<div class="sidebarmenu">
					<a class="menuitem_black" href="configuracion.php">Configuraci&oacute;n</a>                                
				</div>
			
				<!--
				<div class="sidebar_box">
					<div class="sidebar_box_top"></div>
					<div class="sidebar_box_content">
						<h3>Administrador</h3>
						<img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
						<p>
							En este Pandel de Administracion usted puede administrar el contenido de su sitio.<br /><br />
							Cualquien duda sobre su uso contactece con el webmaster de su sitio.
						</p>             
					</div>
					<div class="sidebar_box_bottom"></div>
				</div>	
				-->
				<br />
				<div class="sidebar_box_content">
					<h3>Administrador</h3>
					<img src="images/info.png" alt="" title="" class="sidebar_icon_right" />
					<p>
						En este Pandel de Administraci&oacute;n usted puede administrar a los Usuarios.
						<br />
						Ac&aacute; arriba est&aacute;n accesos directos a los distintos m&oacute;dulos del panel, o bien podes acceder a ellos
						desde el men&uacute;. Tambi&eacute;n cont&aacute;s con un buscador relacionado con el m&oacute;dulo que est&aacute; actualmente activo.
						<br /><br >
						Cualquien duda sobre su uso contactece con el webmaster de su sitio.
					</p> 					
				</div>
				
			</div>  
    
			<div class="right_content">            
			
				<h2><u>Cambiar password del Administrador</u></h2> 
				
				<!-- <h2>Warning Box examples</h2> -->
				<!--
				 <div class="warning_box">
					Corroborar datos
				 </div>
				 <div class="valid_box">
					Ok
				 </div>
				 <div class="error_box">
					Error
				 </div>  
				-->
				<?php
					if(isset($_GET["error"]))
					{
						if($_GET["error"] == 1)
							echo "<span style='color: red'>* Error al cambiar el password del Administrador <br /> * Ingrese el password anterior y el nuevo para poder cambiarlo con &eacute;xito</span>";
						elseif($_GET["error"] == 0)
							echo "<span style='color: green'>* Tu password se ha cambiado con &eacute;xito <br /> * En tu pr&oacute;ximo ingreso al administrador lo har&aacute;s con su password nuevo</span>";
					}
				?>
				<a href="#" name="go"></a>
				 <div class="form">

					<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="formulario" id="formulario">			
						<div id="contenido">	
							<div class="contenedor_campo">
								<?php 
									echo "<label class=\"titulo\">Usuario</label><br />";
									echo "<span style='font-size: 16px; font-weight: bold;color: #333'>Administrador</span>";
								?> 
							</div>
							
							<div class="contenedor_campo">
								<?php 
									echo "<label class=\"titulo\">Password anterior</label><br />";
									echo "<input type='password' name=\"password_ant\" id=\"password_ant\" class=\"campo_text\" value='' />";
								?> 
							</div>	
							
							<div class="contenedor_campo">
								<?php 
									echo "<label class=\"titulo\">Password nuevo</label><br />";
									echo "<input type='password' name=\"password\" id=\"password\" class=\"campo_text\" value='' />";
								?> 
							</div>												
							
							<?php
								echo "<a href='#go' onclick='f_validar_aconfiguracion();' class='bt_black2'><span class='bt_black_lft'></span><strong>Cargar</strong><span class='bt_black_r'></span></a>";
							?>
						</div>
					</form>
				
				 </div>  
				
			</div><!-- end of right content-->
                  
		</div>   <!--end of center content -->               

		<div class="clear"></div>
    </div> <!--end of main content-->
	
	<div class="footer">   
    	<div class="left_footer">:: Cambiar password del Administrador ::</div>
    </div>	
</div>		
</body>
</html>