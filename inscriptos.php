<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

$session = $obj->f_checkSession();
if(!$session) header("location:congreso-micologia.php");

$user         = $obj->f_darCustomerRowSQL($_SESSION['user_congreso']['id']);

if(empty($user)){
  unset($_SESSION['user_congreso']);
  header("location:congreso-micologia.php");
}

$exists_pago  = $obj->f_checkPago($_SESSION['user_congreso']['id']);
$price        = $obj->f_darPriceByCategoriaAndSocio($user['id_category'], $user['socio']);

if(isset($_POST['submit'])){

    $type     = 1;
    $id_user  = $_SESSION['user_congreso']['id'];

    if($_FILES['ticket']['error']==0){
      $tmp_name   = $_FILES['ticket']['tmp_name'];        
      $name_file  =  basename($_FILES['ticket']['name']);
      $names      = explode(".", $name_file);
      $names      = array_reverse($names);
      $extension  = strtolower($names[0]);
      $name_file  = "(" . substr(microtime(), -6) . ")" . utf8_encode($name_file);

      if($extension == "jpg" || $extension == "jpeg"){
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
  header("location:inscriptos.php?err=$err");
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
  
  <!-- Ajust iframe -->
  <script language="javascript" type="text/javascript">
    function resizeIframe(obj) {
      obj.style.height = obj.contentWindow.document.body.scrollHeight + 'px';
    }
  </script>
  
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
          <li><a href="servicios.html">Servicios</a></li>
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
            
            <div style="float: right"> <a href="javascript: void(0);" class="logout" onClick="logout();">Salir</a></div>
            
            <?php if($exists_pago != 1): ?>
              
                <h2>Mi Inscripción </h2>

                <p><span class="rojo"> Debe realizar una Transferencia Bancaria o Depósito por el importe de <b><?="$".$price;?></b> para terminar su inscripción al Congreso, a la siguiente cuenta:</span>
                <div class="cuenta-bancaria">              
                             BANCO SANTANDER RIO<br>
                             Cuenta AsAM: Nº 156-011423/9<br>
                             CBU 0720156720000001142390<br>
                             CUIT: 30-65515233-0<br>
                </div>
         </p>            
                   <p>  Una vez obtenido el ticket o comprobante de pago, adjúntelo presionado el siguiente botón:</p>
                  
                  <div style="margin:0 0 5px 10px">
                  <form id="contacts-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" onSubmit="return validar_ticket()">
                      <label>Adjuntar ticket &nbsp;<font color="#ccc"><em>(*.jpg)</em></font> </label>
                      <input type="file" id="ticket" name="ticket"/>
                      <br />
                      <input type="submit" value="Subir ticket" name="submit" class="submit" style="clear: both"/>
                  </form> 
                  
              </div><br />
              <?php if(isset($msg)) echo $msg; ?>    
              <br>
            <?php endif; ?>         



<h2>Presentación de Trabajos  </h2>
<p>Haga click en adjuntar para seleccionar el trabajo en formato pdf desde su pc y luego presione Aceptar. Haga este proceso de a un trabajo a la vez. <br>

<br />

<iframe src="files.php" width="500" scrolling="no" frameborder="0" onload="javascript:resizeIframe(this);"></iframe>

<h2>Mis Datos </h2>
<p>Nombre: <?=htmlentities($user['first_name'])?><br>
Apellido: <?=htmlentities($user['last_name'])?><br>
DNI: <?=$user['dni']?><br>
E-mail: <?=$user['email']?><br>
Area: <?=htmlentities($user['area_description'])?><br>
Categoría: <?=htmlentities($user['category_description'])?><br>
Socio: <?=($user['socio']==1)?'Si':'No';?><br>
Presentó comprobante de pago: <?=($exists_pago)?'Si':'No';?><br>
            
                

            
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
