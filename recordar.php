<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

if(isset($_POST["email"])){
  $email  = $_POST["email"];
  $exists = $obj->f_checkExistsUser($email);
  if($exists){
    $row        = $obj->f_darCustomerRowByEmailSQL($email);
    $first_name = $row['first_name'];
    $last_name  = $row['last_name'];
    $password   = $row['password'];
    
    $fullname   = $first_name . " " . $last_name;
    $subject    = $oFunctions->company_name . " - Recordar password";
    $msg        = "<div style='color:#333;font-family:Helvetica,Verdana,Arial'>
                    <font color='black' size='5'>" . $fullname . "</font>, este email es un recordatorio de sus datos de acceso
                    al panel de usuario del sitio <b>" . $oFunctions->company_name . "</b> <br /><br />
                    <u><em>Datos de acceso</em></u>:
                    <table border='0' cellpadding='2'>
                      <tr>
                        <td style='text-align:right'><b>Usuario/email:</b></td>
                        <td>" . $email . "</td>
                      </tr>
                      <tr>
                        <td style='text-align:right'><b>Password:</b></td>
                        <td>" . $password . "</td>
                      </tr>
                    </table>
                    <br />
                    <b>Muchas gracias.</b>
                  </div>";
    $oFunctions->sendEmail("no-reply@ltlorganizacion", $oFunctions->company_name, $email, $fullname, $subject, $msg);

    $err = 0;
  }else{
    $err = 1;
  }
  header("location:recordar.php?err=$err");
}

if(isset($_GET["err"])){
  if($_GET["err"] == 0){
    $msg  = "<div class='success'>
              Los datos de acceso fueron env&iacute;ados con &eacute;xito a su casilla de email.<br />
              Si no recibe el mail, recuerde verificar su correo no deseado.
            </div>";
  }else{
    $msg  = "<div class='error'>
              Error al intentar recuperar la contrase&ntilde;a <br />
              Corrobore ingresar correctamente su email con el cual se inscribi&oacute;.<br />
              
            </div>";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Recordar contraseña - Inscripción al XIII Congreso Argentino de Micología</title>
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
</head>

<body>
  <!-- header -->
  <header>
    <div class="container">
    	<h1></h1>
      <nav>
        <ul>
        	<li><a href="index.php">Home</a></li>
          <li><a href="servicios.htm">Servicios</a></li>
          <li><a href="contacto.php">Contacto</a></li>
           <li><a href="congreso-micologia.php" class="current">Congreso</a></li>
         
        </ul>
      </nav>
    </div>
	</header>
 

  <div class="main-box">
    <div class="container">
      <div class="inside">
        <div class="wrapper">
        	<!-- aside -->
          <aside>
            <?php include("congreso.php");?>
          </aside>
          <!-- content -->
          <section id="content">
            <article>
            	<h2>Recuperar <span>Contraseña.</span></h2>
              
         
             <p> Por favor, Ingrese la dirección de e-mail con la cual se inscribió al Congreso y le enviaremos un e-mail con su usuario y contraseña.
             
         <form id="contacts-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             	
                	<div class="field2">
                    <label>Email:</label>
                    <input type="email" value="" name="email" id="email" required/>
                  </div>
                    <br />
<br />


                 <input type="submit" value="Enviar" class="submit"/>
                 
             </form>
             
         
               
               
</p>
     <?php if(isset($msg)) echo $msg; ?>           
<br>
<br>

<p>
<figure><img src="images/logo-congreso-micologia.jpg" width="222" height="85"></figure>
XIII Congreso Argentino de Micología<br>
XXIII Jornadas Argentinas de Micología<br>
1ra Reunión de la Asociación Micológica Carlos Spegazzini<br><br>

Lugar: Círculo de Oficiales de Mar | Sarmiento 1867. C.A.B.A.<br>
Fecha: 24 a 27 de Agosto de 2014
              </p>
            
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
