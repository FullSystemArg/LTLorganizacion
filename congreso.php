<script type="text/javascript">
<!--
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
//-->
</script>
<body onLoad="MM_preloadImages('images/bt-autoridades2.jpg','images/bt-trabajos2.jpg','images/bt-aranceles2.jpg')">
	<h2>XIII Congreso Argentino de Micología </h2>
              
			<?php if(isset($msg)) echo $msg; ?>
              
             <div>
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
	<br>
	<div align="center">
		<a href="autoridades-congreso-micologia.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image5','','images/bt-autoridades2.jpg',1)"><img src="images/bt-autoridades1.jpg" name="Image5" width="236" height="98" border="0"></a><br>
		<a href="Cursos-Precongreso.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image9','','images/bt-cursos2.jpg',1)"><img src="images/bt-cursos1.jpg" name="Image9" width="236" height="98" border="0"></a><br>
		<a href="programa-cientifico-congreso-micologia.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image6','','images/bt-programa2.jpg',1)"><img src="images/bt-programa1.jpg" name="Image6" width="236" height="97" border="0"></a><br>
		<a href="trabajos-cientificos-congreso-micologia.html" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image7','','images/bt-trabajos2.jpg',1)"><img src="images/bt-trabajos1.jpg" name="Image7" width="236" height="97" border="0"></a><br>
		<a href="aranceles-congreso-micologia.htm" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image8','','images/bt-aranceles2.jpg',1)"><img src="images/bt-aranceles1.jpg" name="Image8" width="236" height="97" border="0"></a><br>
		<a href="inscripcion-congreso-micologia.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Image10','','images/bt-inscripcion2.jpg',1)"><img src="images/bt-inscripcion1.jpg" name="Image10" width="236" height="97" border="0"></a>
	</div>
