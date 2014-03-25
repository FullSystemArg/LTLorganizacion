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
	$msg  = "<div style='color:#333;font-family:Helvetica,Verdana,Arial'>
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

if(isset($_GET["v"])){
	if($_GET["v"] == 1){
		$msg  = "<div class='success'>
              Ya ha validado su usuario, ahora puedes acceder al panel ingresando 
              sus datos de Email y Contrase&ntilde;a.<br />
              Muchas Gracias.
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

<style>
		.tabrow {
		    text-align: center;
		    list-style: none;
		    margin: 20px 0 20px;
		    padding: 0;
		    line-height: 24px;
		    height: 26px;
		    overflow: hidden;
		    font-size: 12px;
		    font-family: verdana;
		    position: relative;
		}
		.tabrow li {
		    border: 1px solid #AAA;
		    background: #D1D1D1;
		    background: -o-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);
		    background: -ms-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);
		    background: -moz-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);
		    background: -webkit-linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);
		    background: linear-gradient(top, #ECECEC 50%, #D1D1D1 100%);
		    display: inline-block;
		    position: relative;
		    z-index: 0;
		    border-top-left-radius: 6px;
		    border-top-right-radius: 6px;
		    box-shadow: 0 3px 3px rgba(0, 0, 0, 0.4), inset 0 1px 0 #FFF;
		    text-shadow: 0 1px #FFF;
		    margin: 0 -5px;
		    padding: 0 20px;
		}
		.tabrow a {
			  color: #555;
			  text-decoration: none;
		}
		.tabrow li.selected {
		    background: #FFF;
		    color: #333;
		    z-index: 2;
		    border-bottom-color: #FFF;
		}
		.tabrow:before {
		    position: absolute;
		    content: " ";
		    width: 100%;
		    bottom: 0;
		    left: 0;
		    border-bottom: 1px solid #AAA;
		    z-index: 1;
		}
		.tabrow li:before,
		.tabrow li:after {
		    border: 1px solid #AAA;
		    position: absolute;
		    bottom: -1px;
		    width: 5px;
		    height: 5px;
		    content: " ";
		}
		.tabrow li:before {
		    left: -6px;
		    border-bottom-right-radius: 6px;
		    border-width: 0 1px 1px 0;
		    box-shadow: 2px 2px 0 #D1D1D1;
		}
		.tabrow li:after {
		    right: -6px;
		    border-bottom-left-radius: 6px;
		    border-width: 0 0 1px 1px;
		    box-shadow: -2px 2px 0 #D1D1D1;
		}
		.tabrow li.selected:before {
		    box-shadow: 2px 2px 0 #FFF;
		}
		.tabrow li.selected:after {
		    box-shadow: -2px 2px 0 #FFF;
		}
	</style>

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
<h2>XIII Congreso Argentino de Micología</h2>
<br><br>
            <img src="images/foto-autoridades2.jpg" width="302" height="305">
          </aside>

          <section id="content">
            <article>
    <h2>Inscripción. <span>Congreso Argentino de Micología</span></h2>
    <ul class="tabrow">
		<li style="font-size:xx-small"><a href="autoridades-congreso-micologia.htm">Autoridades</a></li>
	    <li style="font-size:xx-small"><a href="Cursos-Precongreso.htm">Cursos</a></li>
	    <li style="font-size:xx-small"><a href="programa-cientifico-congreso-micologia.html">Programa</a></li>
	    <li style="font-size:xx-small"><a href="trabajos-cientificos-congreso-micologia.html">Trabajos Científicos</a></li>
	    <li style="font-size:xx-small"><a href="aranceles-congreso-micologia.htm">Aranceles</a></li>
	    <li style="font-size:xx-small" class="selected">Inscripción</li>
	</ul>
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
