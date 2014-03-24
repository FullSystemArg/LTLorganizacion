<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

if(isset($_POST["first_name"])){
  $first_name     = utf8_decode($_POST["first_name"]);
  $last_name      = utf8_decode($_POST["last_name"]);
  $dni            = $_POST["dni"];
  $email          = utf8_decode($_POST["email"]);
  $id_area        = $_POST["id_area"];
  $id_category    = $_POST["id_category"];
  $socio          = $_POST["socio"];
  $password       = $_POST["password"];
  $confirm_email  = 0;
  $status         = 0;

  $exists = $obj->f_checkExistsUser($email);

  if($exists == 0){
    $id = $obj->f_nuevoSQL(
                $first_name,
                $last_name,
                $dni,
                $email,
                $id_area,
                $id_category,
                $socio,
                $password,
                $status,
                $confirm_email
                );

    $fullname   = $first_name . " " . $last_name;
    $subject    = $oFunctions->company_name . " - Confirmar Inscripcion a Congreso Argentino de Micologia";

    $id_user    = base64_encode($id);
    $tokken     = sha1(microtime());
    $msg        = "<div style='color:#333;font-family:Helvetica,Verdana,Arial'>
                    <font color='#000' size='5'>" . $fullname . "</font>, se ha Inscripto al Congreso Argentino de Micolog&iacute;a.<br />
                    Solo queda que confirme su inscripcion haciendo click 
					<a href='" . $oFunctions->company_page . "/validate_user/validate.php?i=" . $id_user . "&token=_" . $tokken. "_RG'><b>Aqu&iacute;</b></a>.
                    <br /><br />
                    <b>Muchas gracias.</b>
                  </div>";

    $oFunctions->sendEmail("no-reply@ltlorganizacion", $oFunctions->company_name, $email, $fullname, $subject, $msg);

    $err = 0;
  }else{
    $err = 1;
  }
  header("location:inscripcion-congreso-micologia.php?err=$err");
}

if(isset($_GET["err"])){
  if($_GET["err"] == 0){
    $msg  = "<div class='success'>
              Se ha inscripto de manera exitosa.<br /> 
              En instantes recibir&aacute; un email
              de confirmaci&oacute;n para que pueda validar sus datos y as&iacute; poder acceder al panel de Usuario Registrados
              de nuestro sitio.<br />
			  Si no recibe el email, recuerde revisar su casilla de correo no deseado.<br />
              </div>";
  }else{
    $msg  = "<div class='error'>
              Error de inscrpci&oacute;n.<br />
              Puede ser que ya haya otro usuario registrado con el mismo email asignado.
              Por favor revise nuevamente tus datos y vuelva a intenarlo.<br />
              
            </div>";
  }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <title>Inscripción. XIII Congreso Argentino de Micología</title>
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
      
          <section id="content">
            <article>
            	<h2>Inscripción. <span>Congreso Argentino de Micología</span></h2>
              <?php if(isset($msg)) echo $msg; ?> 
              <?php if(!isset($_GET["err"]) || $_GET["err"] != 0): ?>
             	  <form id="contacts-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" onSubmit="return validar_pw()">
                  <fieldset>
                    <div class="field">
                      <label>Nombre:</label>
                      <input type="text" value="" name="first_name" id="first_name" required/>
                    </div>
                    <div class="field">
                      <label>Apellido:</label>
                      <input type="text" value="" name="last_name" id="last_name" required/>
                    </div>
                    <div class="field">
                      <label>DNI:</label>
                      <input type="text" value="" name="dni" id="dni" required/>
                    </div>
                    <div class="field">
                      <label> E-mail:</label>
                      <input type="email" value="" name="email" id="email" required/>
                    </div>
                    <div class="field">
                      <label>Area:</label>
                      <select name='id_area' id='id_area' required>
                        <option selected='selected' value=''>-Seleccione-</option>
                        <?php 
                          $result = mysql_query("SELECT * FROM tbl_area");
                          while($row = mysql_fetch_object($result)){
                              echo"<option value=" . $row->id . ">" . utf8_encode($row->description) . "</option>";
                          }                 
                        ?> 
                      </select>
                    </div>
                    <div class="field">
                      <label>Categoría:</label>
                      <select name='id_category' id='id_category' class='changeprice' required>
                        <option selected='selected' value=''>-Seleccione-</option>
                        <?php 
                          $result = mysql_query("SELECT * FROM tbl_category");
                          while($row = mysql_fetch_object($result)){
                              echo"<option value=" . $row->id . ">" . $row->description . "</option>";
                          }                 
                        ?> 
                      </select>
                    </div>
                     <div class="field">
                      <label>Socio:</label>
                      <select name='socio' id='socio' class='changeprice' required>
                        <option value='' selected='selected'>-Seleccione-</option>  
                        <option value='1'>Si (ASAM)</option>
                        <option value='2'>Si (AMCS)</option>
                        <option value='0'>No</option>
  					           </select>                          
                       <br>
                      <div class="costo">Costo de la Inscripción: <b>-</b></div>
                    </div>
                    
                      <div class="field">
                      <label>Contraseña:</label>
                      <input type="password" value="" name="password" id="password" required/>
                    </div>
                    <div class="field">
                      <label>Repetir Contraseña:</label>
                      <input type="password" value="" name="password2" id="password2" required/>
                    </div><br>
                  <br>

                    <div><input type="submit" value="Inscribirse" class="submit"/></div>
                    
                    <br>

                  </fieldset>
                </form>
                <?php endif; ?>
                <br>

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
