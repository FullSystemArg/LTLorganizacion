<?php
require_once("class/customer.class.php");
require_once("class/functions.class.php");

if(isset($_GET['id'])){
	$id = $_GET['id'];		
	$row 	= $obj->f_darFileById($id);
	$path 	= $oFunctions->path_absolute;
	$enlace = $path . "/" . $oFunctions->path_file . $row["file"];
	$obj->f_eliminarFileSQL($id);
	@unlink($enlace);
}
return true;
?>