<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

$categoria 	= $_POST["categoria"];
$socio 		= $_POST["socio"];

$total = $obj->f_darPriceByCategoriaAndSocio($categoria, $socio);

echo $total;