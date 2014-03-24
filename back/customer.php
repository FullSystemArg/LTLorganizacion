<?php
require_once("class/customer.class.php");
require_once("class/functions.class.php");
require_once("class/resize.class.php");

/*
*	var action : 1 (ADD)
*				 2 (EDIT)
*                3 (VIEW)
*/

$oFunctions->isLoggedIn();

//Funcion remplace
function func_replace($str){
	$str = htmlentities($str);
	return $str;
}

if(isset($_GET['action'])){
	$action = $_GET['action'];
	if($action <= 3){
		if($action != 0 && $action != 1){
			if($_GET['id']>0) $id= $_GET['id']; 
			else $action = 0;		
		}
	}else $action = 0;
}

if(isset($id)){
	$rowSQL = $obj->f_darCustomerRowSQL($id);
}

if(isset($_POST["first_name"]) != ''){

	$first_name		= $_POST["first_name"];
	$last_name 		= $_POST["last_name"];
	$dni 			= $_POST["dni"];
	$email 			= $_POST["email"];
	$id_area 		= $_POST["id_area"];
	$id_category 	= $_POST["id_category"];
	$socio 			= $_POST["socio"];
	$password 		= $_POST["password"];
	$confirm_email  = 1;
	$status			= $_POST["status"];

	$id 			= (isset($_POST["id"]))? $_POST["id"] : null; //Para modificar
	$exists 		= $obj->f_checkExistsUser($email, $id);

	if($exists == 0){
		if ($id>0){
			$obj->f_modificarSQL(
								$id,
								$first_name,
								$last_name,
								$dni,
								$email,
								$id_area,
								$id_category,
								$socio,
								$password,
								$status,
								$confirm_email
								);
		}else{
			$obj->f_nuevoSQL(
							$first_name,
							$last_name,
							$dni,
							$email,
							$id_area,
							$id_category,
							$socio,
							$password,
							$status,
							$confirm_email
							);
		}
		$err = 0;
	}else{ $err = 1; }
	
	header("location:customer.php?err=".$err);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html" charset="iso-8859-1" />
<title>:: Administrador | Usuarios ::</title>

<!-- Styles -->
<link href="css/style_lis.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

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

<!-- Ajax -->
<script type="text/javascript" src="js/ajax.js"></script>

<!-- Ajust iframe -->
<script language="javascript" type="text/javascript">
  function resizeIframe(obj) {
    obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
  }
</script>
<!-- -->

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
			Bienvenido Admin,  <a href="session_delete.php" class="logout">Salir</a>
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
			
				<h2><u>Administrar Usuarios</u></h2> 
				
				<?php if(isset($_GET["err"]) && $_GET["err"] == 0) echo '<div class="valid_box">Operaci&oacute;n procesada con &eacute;xito.</div>'; ?>
				<?php if(isset($_GET["err"]) && $_GET["err"] == 1) echo '<div class="error_box">Error al intentar cargar el registro. <br/> Puede ser que ya haya un usuario asociado con el email ingresado.</div>'; ?>

				<div id="customer" style="height:auto">
					<?php include('customer_lis.php'); ?>
				</div>
				
				 <a href="customer.php?action=1#go" class="bt_black"><span class="bt_black_lft"></span><strong>Nuevo registro</strong><span class="bt_black_r"></span></a>
				
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
				
				<div class="clear" style="padding-top: 15px">
					<hr style='border: 1px dotted #CBC37B' /><br />	
				</div>
				
				
				<a href="#" name="go"></a>
				 <div class="form">
						<?php
						if(isset($action) && $action != 0){
						
							switch($action){
								case 1:
									echo "<h2>Nuevo Registro</h2>";
									break;
								case 2:
									echo "<h2>Actualizar Registro</h2>";
									break;
								case 3:
									echo "<h2>Visulizar Registro</h2>";
									break;
							}
						?>
						
						<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="formulario" id="formulario">			
							<div id="contenido">	
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Nombre</em></u></label><br />";
									if($action==2) {
										echo "<input type=\"text\" name=\"first_name\" id=\"first_name\" class=\"campo_text\" value='".func_replace($rowSQL["first_name"])."' />";
									}elseif($action==1){  
										echo "<input type=\"text\" name=\"first_name\" id=\"first_name\" class=\"campo_text\" />";
									}else{;
										echo "<div><br />".func_replace($rowSQL["first_name"])."</div>";
									}
									?> 
								</div>										
								
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Apellido</em></u></label><br />";
									if($action==2) {
										echo "<input type=\"text\" name=\"last_name\" id=\"last_name\" class=\"campo_text\" value='".func_replace($rowSQL["last_name"])."' />";
									}elseif($action==1){  
										echo "<input type=\"text\" name=\"last_name\" id=\"last_name\" class=\"campo_text\" />";
									}else{;
										echo "<div><br />".func_replace($rowSQL["last_name"])."</div>";
									}
									?> 
								</div>										

								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>DNI</em></u></label><br />";
									if($action==2) {
										echo "<input type=\"text\" name=\"dni\" id=\"dni\" class=\"campo_text\" value='".func_replace($rowSQL["dni"])."' />";
									}elseif($action==1){  
										echo "<input type=\"text\" name=\"dni\" id=\"dni\" class=\"campo_text\" />";
									}else{
										echo "<div><br />".func_replace($rowSQL["dni"])."</div>";
									}
									?> 
								</div>	
								
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Email</em></u></label><br />";
									if($action==2) {
										echo "<input type=\"text\" name=\"email\" id=\"email\" class=\"campo_text\" value='".func_replace($rowSQL["email"])."' />";
									}elseif($action==1){  
										echo "<input type=\"text\" name=\"email\" id=\"email\" class=\"campo_text\" />";
									}else{
										echo "<div><br />".func_replace($rowSQL["email"])."</div>";
									}
									?> 
								</div>
								
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Area</em></u></label><br />";
									if($action==2 || $action==1) {		
										echo "<select name='id_area' id='id_area' class='campo_list'>";
										echo "	<option value='0'>Seleccione</option>";
										$result = mysql_query("SELECT * FROM tbl_area");
										while($row = mysql_fetch_array($result)){
											if($row["id"] == $rowSQL["id_area"]){
												echo "<option value=".$row["id"]." selected>".utf8_encode($row["description"])."</option>";																				
											}else{
												echo"<option value=".$row["id"].">".utf8_encode($row["description"])."</option>";
											}
										}									
										echo "</select>";
									}else{  
										echo "<br />".utf8_encode($rowSQL["area_description"]);
									}
									?> 
								</div>
								
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Categor&iacute;a de Inscripci&oacute;n</em></u></label><br />";
									if($action==2 || $action==1) {
										echo "<select name='id_category' id='id_category' class='campo_list'>";
										echo "	<option value='0'>Seleccione</option>";
										$result = mysql_query("SELECT * FROM tbl_category");
										while($row = mysql_fetch_array($result)){
											if($row["id"] == $rowSQL["id_category"]){
												echo "<option value=".$row["id"]." selected>".func_replace($row["description"])."</option>";																				
											}else{
												echo"<option value=".$row["id"].">".func_replace($row["description"])."</option>";
											}
										}									
										echo "</select>";
									}else{  
										echo "<br />".func_replace($rowSQL["category_description"]);
									}
									?> 
								</div>
								
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Socio</em></u></label><br />";
									if($action==2 || $action==1) {
										echo "<select name='socio' id='socio' class='campo_list'>";
											if(isset($rowSQL["socio"]) && $rowSQL["socio"] == 1){
												echo "	<option value='1' selected>Si (ASAM)</option>";																				
												echo "	<option value='2'>Si (AMCS)</option>";																				
												echo "	<option value='0'>No</option>";																				
											}elseif(isset($rowSQL["socio"]) && $rowSQL["socio"] == 2){
												echo "	<option value='2' selected>Si (AMCS)</option>";																				
												echo "	<option value='1'>Si (ASAM)</option>";																				
												echo "	<option value='0'>No</option>";																				
											}else{
												echo "	<option value='0' selected>No</option>";																				
												echo "	<option value='1'>Si (ASAM)</option>";																				
												echo "	<option value='2'>Si (AMCS)</option>";	
											}
										echo "</select>";								
									}else{  
										echo "<br />";
										if($rowSQL["socio"] == 1) echo 'Si (ASAM)'; 
										elseif($rowSQL["socio"] == 2) echo 'Si (AMCS)'; 
										else echo 'No';
									}
									?> 
								</div>
									
								<?php if( $action == 2 || $action == 1): ?>
								<div class="contenedor_campo">
									<?php 
									echo "<label class=\"titulo\"><u><em>Password</em></u></label><br />";
									if($action==2) {
										echo "<input type=\"password\" name=\"password\" id=\"password\" class=\"campo_text\" value='".func_replace($rowSQL["password"])."' />";
									}elseif($action==1){  
										echo "<input type=\"password\" name=\"password\" id=\"password\" class=\"campo_text\" />";
									}
									?> 
								</div>
								<?php endif; ?>
								
								<div class="contenedor_campo" style="border-color: peru">
									<?php 
									echo "<label class=\"titulo\" style=\"color: peru\"><u><em>Estado</em></u></label><br />";
									if($action==2 || $action==1) {
										echo "<select name='status' id='status' class='campo_list'>";
										if($rowSQL["status"] == 1){
											echo "<option value='1' selected>Habilitado</option>";																				
											echo "<option value='0'>Deshabilitado</option>";																				
										}else{
											echo "<option value='0' selected>Deshabilitado</option>";																				
											echo "<option value='1'>Habilitado</option>";
										}
										echo "</select>";
									}else{ 
										if($rowSQL["status"] == 1) echo "<br />Habilitado";
										else echo "<br />Deshabilitado";
									}
									?> 
								</div>
								
								<?php
								if($action==2) echo "<input type='hidden' id='id' name='id' value='".$id."'/>";
								
								echo "<div style='clear: both'>";
								if($action!=3) echo "<a href='#go' onclick='f_validar_customer();' class='bt_black2'><span class='bt_black_lft'></span><strong>Cargar</strong><span class='bt_black_r'></span></a>";
								else echo "<a href='customer.php' class='bt_black2'><span class='bt_black_lft'></span><strong>Volver</strong><span class='bt_black_r'></span></a>";
								echo "</div>";
								?>
							</div>
						</form>
					<?php
					}
					?>					
				 </div>  
				

				<?php
				if($action == 2 || $action == 3){
					echo '<div class="clear" style="padding-top: 15px">';
					echo '	<hr style="border: 1px dotted #CBC37B" /><br />';
					echo '</div>';
					echo '<iframe src="customer_file.php?id_user='.$id.'" width="635" scrolling="no" frameborder="0" onload="javascript:resizeIframe(this);"></iframe>';
				}
				?>
				
				
			</div><!-- end of right content-->
                  
		</div>   <!--end of center content -->               

		<div class="clear"></div>
    </div> <!--end of main content-->
	 
	<div class="footer">   
    	<div class="left_footer">:: Administrar Usuarios ::</div>
    </div>
	
</div>		
</body>
</html>