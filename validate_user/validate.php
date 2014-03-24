<?php
require_once("../back/class/customer.class.php");
require_once("../back/class/functions.class.php");

if(!isset($_GET["i"])){
	header("location:" . $oFunctions->company_page);
}

$id 	= base64_decode($_GET["i"]);
$row 	= $obj->f_darCustomerRowSQL($id);

if($row["id"] <= 0){
	header("location:" . $oFunctions->company_page);
}

$validate = $obj->f_checkValidateUser($id);

if($validate == 1){
	$obj->f_generateValidateUser($id);
}else{
	header("location:" . $oFunctions->company_page);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Validación. XIII Congreso Argentino de Micología</title>
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
  
<script language="javascript">
  function redireccionar() {
    setTimeout("location.href='http://www.ltlorganizacion.com.ar/congreso-micologia.php?v=1'", 5000);
  }
</script>

</head>
<body onload="redireccionar()">
	<p style="font-size:14px">
	Espere unos segundos mientras se genera la validaci&oacute;n para ingresar al sistema...<br />
	En instantes será redirigido a: <em><?=$oFunctions->company_page;?></em>
	</p>
</body>
</html>