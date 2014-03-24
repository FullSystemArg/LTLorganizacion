<?php
require_once("class/customer.class.php");
require_once("class/functions.class.php");

if(isset($_GET['id'])){
	$id = $_GET['id'];		
	$querySQL = $obj->f_eliminarSQL($id);

	$row_files_by_user = $obj->f_darFilesByUser($id);
	while($row = mysql_fetch_object($row_files_by_user)){
		$row_ 	= $obj->f_darFileById($row->id);
		$path 	= $oFunctions->path_absolute;
		$enlace = $path . "/" . $oFunctions->path_file . $row_["file"];
		$obj->f_eliminarFileSQL($row->id);
		@unlink($enlace);
	}

}

header("location:customer.php?err=0");
?>