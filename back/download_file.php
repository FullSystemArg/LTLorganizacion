<?php
require_once("class/customer.class.php");
require_once("class/functions.class.php");

$id_file = base64_decode($_GET["id_file"]);

$row_file = $obj->f_darFileById($id_file);
$file 	= $row_file["file"];

$path 	= $oFunctions->path_absolute;
$enlace = $path . "/" . $oFunctions->path_file . $file;
header ("Content-Disposition: attachment; filename=$file\n\n");
header ("Content-Type: application/octet-stream");
header ("Content-Length: ".filesize($enlace));
readfile($enlace);