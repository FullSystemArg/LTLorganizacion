<?php
require_once("class/customer.class.php");
require_once("class/functions.class.php");
require_once("class/resize.class.php");

/*
* Type: 1) Tickets
*		2) Trabajos
*		Esta el comentario en la tabla tbl_file campo type
*/ 

//Funcion replace
function func_replace($str){
	$str = utf8_encode($str);
	return $str;
}

function validarExtension($extension, $arr_ext){
	for ($i = 0; $i <= count($arr_ext); $i++){
		if($extension == $arr_ext[$i]){
			return true;
			exit();
		}
	}
	return false;
}

if(isset($_POST["id_user"])){
	$id_user	= $_POST["id_user"];
	$file 		= utf8_decode($_POST["file"]);
	$type 		= utf8_decode($_POST["type"]);

	if($type == 1){
		$arr_ext 	= array("jpg");
	}else{
		$arr_ext 	= array("pdf", "jpg");
	}

	if($_FILES['file']['error']==0){
		$tmp_name 	= $_FILES['file']['tmp_name'];				
		$name_file 	=  basename($_FILES['file']['name']);
		$names 		= explode(".", $name_file);
		$names 		= array_reverse($names);
		$extension 	= strtolower($names[0]);
		$name_file	= "(" . substr(microtime(), -6) . ")" . func_replace($name_file);
		if(validarExtension($extension, $arr_ext)){
			if(move_uploaded_file($tmp_name, "upload_files/" . $name_file)){
				$id = $obj->f_nuevoFileSQL(
						$id_user,
						$name_file,
						$type
						);
				$err = 0; //No hay error
			}else $err = 1; //No se pudo subir el archivo
		}else $err = 2; //La extension no esta permitida
	}

	header("location:customer_file.php?id_user=".$id_user."&err=".$err);
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-type" content="text/html" charset="iso-8859-1" />

<!-- Styles -->
<link href="css/style_lis.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" type="text/css" href="css/style.css" />

<!-- Js -->
<script type="text/javascript" src="js/jquery.min.js"></script>

<!-- Ajax -->
<script type="text/javascript" src="js/ajax.js"></script>
</head>
<body style="background-color: transparent; background-image: none">
 <div class="form" style="height: auto">
 	<h2>Archivos</h2>
 	
 	<p>
 		<em>
 		Extensiones v&aacute;lidas: <span style="color: #666">Tickets: <b>*.jpg</b> / Trabajos: <b>*.jpg</b> y <b>*.pdf</b> </span>	
 		</em>
 	</p>
 	
	<?php if(isset($_GET["err"]) && $_GET["err"] == 0) echo '<div class="valid_box">Archivo cargado con &eacute;xito.</div>'; ?>
	<?php if(isset($_GET["err"]) && $_GET["err"] == 1) echo '<div class="error_box">Error al intentar cargar el Archivo</div>'; ?>
	<?php if(isset($_GET["err"]) && $_GET["err"] == 2) echo '<div class="warning_box">La extensi&oacute;n del Archivo no esta permitida.</div>'; ?>
	<div class="msj_ajax"></div>
					  			 			 				  			 			 
	<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" name="formulario_file" id="formulario_file">			
		<div id="contenido" style="height: 130px;">										
			<div class="contenedor_campo">
				<label class="titulo"><u><em>Tipo de archivo</em></u></label><br />
				
				<select name='type' id='type' class='campo_list'>
				<?php
					$result = $obj->f_darFileByType($_GET["id_user"], 1);
					if(mysql_num_rows($result) == 0){
						echo "<option value='1' selected>Tickets</option>";
						echo "<option value='2'>Trabajos</option>";	
					}else{
						echo "<option value='2' selected>Trabajos</option>";
					}
				?>																		
				</select>
			</div>
	
			<div class='contenedor_campo'>
				<label class="titulo"><u><em>Seleccione un archivo</em></u></label><br />
				<input type='file' name='file' id='file'/> 
			</div>	
				
			<div style='clear: both'>
			<input type='hidden' name='id_user' id='id_user' value='<?php echo $_GET["id_user"]; ?>'/>
				<a href='#go' onclick='f_validar_file();' class='bt_black2'><span class='bt_black_lft'></span><strong>Cargar</strong><span class='bt_black_r'></span></a>
			</div>
			
		</div>
	</form>	
	
	<div id="contenido-file">
		<div class="column1">
			<b><u>Tickets</u> <em>(1 archivo)</em></b>
			<br /><br />
			<?php
				while($row=mysql_fetch_array($result)){
					//list($time, $file_name) = explode(")", $row["file"]);
					$file_name = explode(")", $row["file"]);
					$file_name = $file_name[count($file_name) - 1];
					echo "<div class='files' id='file_".$row["id"]."'> <div class='item'> <a href='download_file.php?id_file=".base64_encode($row["id"])."' title='Descargar'>".$file_name."</a></div> <div class='del-item'><a href='javascript: void(0);' onclick='deleteFile(".$row["id"].")' class='delete-item'>X</a></div> </div>";
				}
			?>
		</div>
		<div class="column2">
			<b><u>Trabajos</u></b>
			<br /><br />
			<?php
				$result = $obj->f_darFileByType($_GET["id_user"], 2);
				while($row=mysql_fetch_array($result)){
					//list($time, $file_name) = explode(")", $row["file"]);
					$file_name = explode(")", $row["file"]);
					$file_name = $file_name[count($file_name) - 1];
					echo "<div class='files' id='file_".$row["id"]."'> <div class='item'> <a href='download_file.php?id_file=".base64_encode($row["id"])."' title='Descargar'>".$file_name."</a></div> <div class='del-item'><a href='javascript: void(0);' onclick='deleteFile(".$row["id"].")' class='delete-item'>X</a></div> </div>";
				}
			?>
		</div>
	</div>		
		
 </div>  
</body>
</html>