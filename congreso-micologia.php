<?php
require_once("back/class/customer.class.php");
require_once("back/class/functions.class.php");

$session = $obj->f_checkSession();
if($session) header("location:inscriptos.php");

if(isset($_POST["email"])){
  $email     = utf8_decode($_POST["email"]);
  $password  = utf8_decode($_POST["password"]);

  $exists = $obj->f_checkExistsUser($email);

  if($exists == 1){
    $checkPass  = $obj->f_checkLogin($email, $password);
    if($checkPass == 1){
      $row        = $obj->f_darCustomerRowByEmailSQL($email);
      $id         = $row['id'];
      $first_name = $row['first_name'];
      $last_name  = $row['last_name'];
      $password   = $row['password'];
      $obj->f_generateSession($id, $first_name, $last_name, $email);
      header("location:inscriptos.php");    
    }else{ header("location:congreso-micologia.php?err=1");}
  }else{ header("location:congreso-micologia.php?err=1");}
}

if(isset($_GET["err"])){
  if($_GET["err"] == 1){
    $msg  = "<div class='error'>
              Error al intentar ingresar al panel de Usuarios Registrados.<br>

              Por favor ingrese correctamente sus datos y vuelva a intentarlo.
              
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
  <title>Ingreso - Inscripción al XIII Congreso Argentino de Micología 2014</title>
  <meta name="description" content="Inscribirse al XIII Congreso Argentino de Micología 2014. XXIII Jornadas Argentinas de Micología. 1ra Reunión de la Asociación Micológica Carlos Spegazzini">
  <meta name="keywords" content="2014, inscribirse, ingreso, inscripción, Congreso, Argentino, Micología, jornadas, Reunión, Asociación, Micológica, Carlos Spegazzini">
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
            	<h2>Ingreso/Inscripción <span>al Congreso.</span></h2>
              
              
              <?php if(isset($msg)) echo $msg; ?>
              
              
             <div class="registrados">
             	<div class="registrados-titulo">Ingreso Usuarios Registrados</div>
             
             <form id="contacts-form" action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
             	
                	<div class="field2">
                    <label>Email:</label>
                    <input type="email" value="" name="email" id="email" required/>
                  </div>
                  
                  <div class="field2">
                    <label>Contraseña:</label>
                    <input type="password" value="" name="password" id="password" required/>
                  </div>
                
                  <input type="submit" value="Ingresar" class="submit bt2"/>
                
             </form>
			<br>
<a href="recordar.php">¿Olvidó su Contraseña? Click aquí</a>
             </div><!-- fin resgistrados -->
             
             
             <div class="separador"><img src="images/separador.jpg" width="4" height="192"></div>
             
             <div class="registrarse">
             	<div class="registrarse-titulo">Inscripción al Congreso</div>
                <p>Si no tiene contraseña para iniciar su sesión, debe inscribirse para obtenerla. Esta inscripción se hace por única vez.
               
<a href="inscripcion-congreso-micologia.php" class="bt">Inscribirse</a></p></div><!-- fin resgistrarse -->
                
<div class="clear"></div>
<p>
<figure><img src="images/logo-congreso-micologia.jpg" width="222" height="85"></figure>
XIII Congreso Argentino de Micología<br>
XXIII Jornadas Argentinas de Micología<br>
1ra Reunión de la Asociación Micológica Carlos Spegazzini<br><br>

Lugar: Círculo  Oficiales de Mar | Sarmiento 1867. C.A.B.A.<br>
Fecha: 24 a 27 de Agosto de 2014
              </p>
            
            </article> 
          </section>
        </div>
      </div>
    </div>
  </div>


<!-- content -->
<section id="content">
 <article>
       <h2>LTL Organización.</h2>
<div class="castellano">
              <p>En nombre del Comité Organizador del XIII Congreso Argentino de Micología y de la 1ra Reunión de la Asociación Micológica Carlos Spegazzini les damos cordialmente la bienvenida e invitamos a participar de este evento científico que constituye la reunión más importante de micólogos de Argentina. El mismo se llevará a cabo en los salones del Círculo Oficiales de Mar, ubicado en el macrocentro de la Ciudad de Buenos Aires, del 24 al 27 de Agosto de 2014.</p>
              
             <p> Desde 1966, la Asociación Argentina de Micología (AsAM) ha organizado 22  jornadas y 12  congresos nacionales. En ésta oportunidad, los especialistas de AsAM,  pertenecientes a las distintas áreas de esta disciplina, han aunado esfuerzos conjuntamente con la Asociación Micológica Carlos Spegazzini a fin de brindarles un programa que incluya todos los aspectos de esta ciencia.</p>
<p>Es por ello que en el congreso se presentaran las novedades y los avances en el conocimiento de las variadas áreas de la micología, abarcando tópicos tales como la clínica, el diagnóstico y la terapéutica de la micología humana y animal, las micotoxinas y las micotoxicosis, la biodiversidad,  la taxonomía y la fitopatología.</p>
<span class="columna-ancha">¡Los esperamos!</span>

<span class="columnas">Gerardo Robledo<br>
1ra Reunión de AMCS </span>
<span class="columnas">Alicia Arechavala<br>
XIII Congreso Argentino AsAM</span>

</div>
<div class="clear"></div><br>

<div class="ingles">
              <p>  On behalf of the Organizing Committee of the XIII Argentine Congress of Mycology and 1st. Meeting of the Mycological Association Carlos Spegazzini, it is a pleasure to invite you to take part of this scientific event that represents the more important meeting of Argentine mycologists. The Congress will be held in the lounges of the Círculo Oficiales de Mar, located in Buenos Aires City, on 24-27 August, 2014.</p>
              
             <p>Since 1966, the Argentine Association of Mycology (AsAM) has organized 22 meetings and 12 national congresses. In this one opportunity, the specialists of AsAM, belonging to the different areas of this discipline, have combined efforts together with the Mycological Association Carlos Spegazzini in order to offer a program that includes all the aspects of this science</p>

<p>The congress will be focused on the innovations and the advances in the knowledge of the varied areas of the mycology, including topics such as clinical and therapeutic aspects of human and animal mycology, latest diagnostic tools, antifungal drugs, mycotoxins and mycotoxicosis, the biodiversity, advances in taxonomy and plant pathology.</p>
<span class="columna-ancha">You are all very welcome</span>

<span class="columnas">
	Gerardo Robledo<br>1ra Reunión de AMCS 
</span>
<span class="columnas">
	Alicia Arechavala<br>XIII Congreso Argentino AsAM
</span>
		</div>
	</article> 
</section>


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
