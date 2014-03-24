<?php
if(strlen($_POST["nombreconta"])>0) {
		
	$nombreconta = $_POST["nombreconta"];
	$telefonoconta = $_POST["telefonoconta"];
	$emailconta = $_POST["emailconta"];
	$comentarioconta = $_POST["comentarioconta"];
	
	$gr = "info@ltlorganizacion.com.ar"; 
	$subject = ":: Nueva Consulta desde el site ::";
	//$gr = $nombreconta;
	//$para = $emailconta;

	$cuerpo ='<table width="90%" cellspacing="2" cellpadding="2" style="font-family: verdana, arial; font-size: 10pt;">
		 
			<tr>		 
			<td width="20%" bgcolor="#177797"><b><font color="ffffff">Nombre y Apellido:</font></b></td>
		 	<td width="70%">' . utf8_decode ($nombreconta) . '</td>		 
		  </tr>
			<tr>
		 
			<td width="20%" bgcolor="#177797"><b><font color="ffffff"><b>Tel&eacute;fono:</font></b></td>
		 	<td width="70%"><font color="#177797">' . $telefonoconta . '</font></td>
		 
		  </tr>
			<tr>
		 
			<td width="20%" bgcolor="#177797"><b><font color="ffffff"><b>E-mail:</font></b></td>
		 	<td width="70%"><font color="#177797">' . $emailconta . '</font></td>
		 
		  </tr>
			<tr>
		 
			<td width="20%" bgcolor="#177797"><b><font color="ffffff"><b>Comentarios:</font></b></td>
		 	<td width="70%"><font color="#177797">' . nl2br(utf8_decode($comentarioconta)) . '</font></td>
		 
		  </tr>
		  </table>';
			
		
			mail($gr, $subject, $cuerpo , "From: ". utf8_decode ($nombreconta)." <$emailconta>\r\nMIME-Version: 1.0\r\nContent-type: text/html; charset=iso-8859-1\r\n");
			
	
			header("location:contacto_gracias.php");
			exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Contactese con LTL Organización de Eventos Científicos</title>
  <meta name="description" content="Envíe su consulta para organizar su evento científico, congreso, jornada o simposio">
  <meta name="keywords" content="LTL, organización, eventos, científicos, congresos, jornadas, simposios">
  <meta charset="utf-8">
  <link rel="stylesheet" href="css/reset.css" type="text/css" media="all">
  <link rel="stylesheet" href="css/style.css" type="text/css" media="all">
  <script type="text/javascript" src="js/jquery-1.4.2.min.js" ></script>
  <script type="text/javascript" src="js/cufon-yui.js"></script>
  <script type="text/javascript" src="js/Humanst521_BT_400.font.js"></script>
  <script type="text/javascript" src="js/Humanst521_Lt_BT_400.font.js"></script>
  <script type="text/javascript" src="js/cufon-replace.js"></script>

  <!--[if lt IE 7]>
  	<link rel="stylesheet" href="css/ie/ie6.css" type="text/css" media="all">
  <![endif]-->
  <!--[if lt IE 9]>
  	<script type="text/javascript" src="js/html5.js"></script>
    <script type="text/javascript" src="js/IE9.js"></script>
  <![endif]-->
  
   <!-- google analytics-->
  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45580036-1', 'ltlorganizacion.com.ar');
  ga('send', 'pageview');

</script>

 <script type="text/javascript"> 
  function validar_post() {

if (document.getElementById('nombreconta').value == ''){
alert("Por favor ingrese su Nombre y Apellido");
return false;
}

if (document.getElementById('emailconta').value == ''){
alert("Por favor ingrese su E-mail");
return false;
}else{
	if (!(document.getElementById("emailconta").value.indexOf(".") > 2 && document.getElementById("emailconta").value.indexOf("@") > 0)) {
	alert("Por favor un E-mail valido");
	return false;}
	}

if (document.getElementById('telefonoconta').value == ''){
alert("Por favor ingrese su Teléfono");
return false;
}

if (document.getElementById('comentarioconta').value == ''){
alert("Por favor ingrese su Comentario");
return false;
}

document.nuevo.submit();

}

</script>
</head>

<body>
  <!-- header -->
  <header>
    <div class="container">
    	<h1></h1>
      <nav>
        <ul>
        	<li><a href="index.php">Home</a></li>
          <li><a href="servicios.html">Servicios</a></li>
          <li><a href="contacto.php" class="current">Contacto</a></li>
          <li><a href="congreso-micologia.php">Congreso</a></li>
        </ul>
      </nav>
    </div>
	</header>

  <div class="main-box">
    <div class="container">
      <div class="inside">
        <div class="wrapper">
         
          <section id="content">
            <article>
            	<h2>Contáctese. <span>LTL Organización</span></h2>
              <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="nuevo" id="contacts-form" action="" method="post">
                <fieldset>
                  <div class="field">
                    <label>Nombre y Apellido:</label>
                    <input type="text" name="nombreconta" id="nombreconta"/>
                  </div>
                  <div class="field">
                    <label> E-mail:</label>
                    <input type="email" name="emailconta" id="emailconta"/>
                  </div>
                  <div class="field">
                    <label>Teléfono:</label>
                    <input type="text" name="telefonoconta" id="telefonoconta"/>
                  </div>
                  <div class="field">
                    <label>Mensaje:</label>
                    <textarea name="comentarioconta" id="comentarioconta"></textarea>
                  </div>
                  <div><a href="#" onClick="validar_post();" class="bt">Enviar Mensaje</a></div>
                </fieldset>
              </form>
            </article> 
          </section>
        </div>
      </div>
    </div>
  </div>
  <!-- footer -->
  <footer>
    <div class="container">
    	<div class="wrapper">
        <div class="fleft"><b>LTL</b>. Organización de Eventos Científicos - <a href="mailto:info@ltlorganizacion.com.ar">info@ltlorganizacion.com.ar</a></div>
        <div class="fright">Diseño:<a href="http://www.afterdesign.com.ar" target="_blank"> After Design</a></div>
      </div>
    </div>
  </footer>
  <script type="text/javascript"> Cufon.now(); </script>
</body>
</html>
