<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

$id_user = $_SESSION['user_congreso']['id'];

if(isset($_POST['submit'])){
    $type     = 2;

    if($_FILES['file']['error']==0){
      $tmp_name   = $_FILES['file']['tmp_name'];        
      $name_file  =  basename($_FILES['file']['name']);
      $names      = explode(".", $name_file);
      $names      = array_reverse($names);
      $extension  = strtolower($names[0]);
      $name_file  = "(" . substr(microtime(), -6) . ")" . utf8_encode($name_file);

      if($extension == "pdf"){
        if(move_uploaded_file($tmp_name, $oFunctions->path_file . $name_file)){
          $id = $obj->f_nuevoFileSQL(
              $id_user,
              $name_file,
              $type
              );
          $err = 0; //No hay error
        }else $err = 1; //No se pudo subir el archivo
      }else $err = 2; //La extension no esta permitida
  }else{ $err = 1; }
  header("location:files.php?err=$err");
}

if(isset($_GET["err"])){
  if($_GET["err"] == 1){
    $msg  = "<div class='error'>
              Se ha generado un error al intentar subir el archivo.
              Por favor vuelva a intentarlo nuevamente.<br />
              <b>Gracias y disculpe las molestias.</b>
            </div>";
  }elseif($_GET["err"] == 2){
      $msg  = "<div class='error'>
              Se ha generado un error al intentar subir el archivo.
              La extensi&oacute;n del mismo no esta permitida.<br />
              <b>Gracias y disculpe las molestias.</b>
            </div>";
  }else{ $msg = ''; }
}

?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Ingreso - Inscripción al XIII Congreso Argentino de Micología</title>
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
  <script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
  <script type="text/javascript" src="js/cufon-yui.js"></script>
  <script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
  <script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
 <script type="text/javascript" src="js/cufon-replace.js"></script>
 <script type="text/javascript" src="js/ajax.js"></script>
  <!--[if lt IE 7]>
  	<link rel="stylesheet" href="css/ie/ie6.css" type="text/css" media="all">
  <![endif]-->
  <!--[if lt IE 9]>
  	<script type="text/javascript" src="js/html5.js"></script>
    <script type="text/javascript" src="js/IE9.js"></script>
  <![endif]-->
  
<style type="text/css"> html{min-width: auto!important} </style>
</head>
<body style="background-color: transparent">

<div class="container" style="width: auto">
	<form id="contacts-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" onsubmit="return validar_file()">
	  <label>Adjuntar trabajos &nbsp;<font color="#ccc"><em>(*.pdf)</em></font> </label>
	  <input type="file" id="file" name="file"/>
	  <br />
	  <input type="submit" value="Adjuntar" name="submit" class="submit" style="clear: both"/>
	</form> 
	<br />
	<?php if(isset($msg)) echo $msg; ?> 
	<div class="container-files">
		<?php
			$result = $obj->f_darFileByType($id_user, 2);
			$empty 	= true;
			while($row=mysql_fetch_object($result)){
        //list($time, $file_name) = explode(")", $row->file);
        $file_name = explode(")", $row->file);
        $file_name = $file_name[count($file_name) - 1];
				echo "<div class='files' id='file_".$row->id."'> <div class='item'> <a href='back/download_file.php?id_file=".base64_encode($row->id)."' title='Descargar'>".$file_name."</div> <div class='del-item'><a href='javascript: void(0);' onclick='deleteFile(".$row->id.")' class='delete-item' title='Eliminar'>X</a></div> </div>";
				$empty = false;
			}
			if($empty) echo "<span><em>&iexcl;Empieza a cargar tus trabajos!</em></span>";
		?>
	</div>				
</div>
</body>
</html>