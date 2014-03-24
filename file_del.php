<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

if(isset($_GET['id_file'])){
	$id_file 	= $_GET['id_file'];		
	$row 	= $obj->f_darFileById($id_file);
	$path 	= $oFunctions->path_absolute;
	$enlace = $path . "/" . $oFunctions->path_file . $row["file"];
	$obj->f_eliminarFileSQL($id_file);
	@unlink($enlace);
}
return true;
?>