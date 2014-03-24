<?php
require_once("class/customer.class.php");

//Funcion remplace
if(!function_exists('func_replace')){
	function func_replace($str){
		$str = utf8_encode($str);
		return $str;
	}
}

$tamano_pagina = 50;
if(isset($_GET['campo']) and isset($_GET['orden']) and isset($_GET['pagina']) and isset($_GET['filtro'])){
	$campo=$_GET['campo'];
	$orden=$_GET['orden'];
	$pagina=$_GET['pagina'];
	$inicio = ($pagina - 1) * $tamano_pagina;
	$filtro=$_GET['filtro']; 
}else{
	//por defecto
	$campo='id';
	$orden='DESC';
	$inicio = 0;
	$pagina=1;
	$filtro =' WHERE 1 ';
}

//Filtros
if(isset($_POST["defaultb"]) && strlen($_POST["defaultb"])>0 && $_POST["defaultb"] != "Ingrese su busqueda") { //Filtrado Default por POST
	$defaultb = mysql_escape_string( trim($_POST["defaultb"]) );
	$filtro = $filtro . " AND CONCAT(tbl_customer.first_name,' ',tbl_customer.last_name,' ',tbl_customer.dni) LIKE '%$defaultb%' ";
}elseif(isset($_GET["defaultb"]) && strlen($_GET["defaultb"])>0 && $_GET["defaultb"] != "Ingrese su busqueda"){ //Filtrado Default por GET
	$defaultb = mysql_escape_string( trim($_GET["defaultb"]) );
	$filtro = $filtro . " AND CONCAT(tbl_customer.first_name,' ',tbl_customer.last_name,' ',tbl_customer.dni) LIKE '%$defaultb%' ";
}

//------------------------------------------------------------

//Grilla
$modulo = "customer";
$resultado = $obj->f_darCustomerSQL($filtro,$campo,$orden,$inicio,$tamano_pagina);
$num_total_registros = $obj->f_darCantCustomerSQL($filtro);

//Calculo el total de paginas
$total_paginas = ceil($num_total_registros / $tamano_pagina);

$campos = array ("first_name","last_name","dni","email", "socio", "status");
$tamanos = array("105", "105", "65", "180", "60", "80");//615
$cabecera = array ("Nombre", "Apellido","DNI", "Email", "Socio", "Acciones");
/*
//Los separamos mediante coma
$cabecera= explode(",",$cabecera);
$tamanos = explode(",",$tamanos);
$campos= explode(",",$campos);
*/


echo '<br>';
if ($num_total_registros > 0){//Si hay datos para mostrar arma la grilla con los datos
		
	//echo "<a target='_black' style='margin-bottom: 25px' href='generar_pdf/generar_pdf.php?campo=".base64_encode($campo)."&orden=".base64_encode($orden)."&filtro=".base64_encode($filtro)."&tamano_pagina=".base64_encode($tamano_pagina)."&inicio=".base64_encode($inicio).".' class='bt_black'><span class='bt_black_lft'></span><strong>GENERAR PDF</strong><span class='bt_black_r'></span></a>";
	
	echo '<table border="0" align="center" cellpadding="0" cellspacing="0" class="tabla-calendario"><tr>';
	$i=0;
	$nroItemsArray =count($campos);

	//Mediante un bucle crearemos las columnas
	while($i<=$nroItemsArray-1){
		//Comparamos: si la columna campo es igual al elemento 
		//actual del array 
		if($campos[$i]==$campo){
		//Comparamos: si esta Descendente cambiamos a Ascendente
		//y viceversa
			if($orden=="DESC"){
				$orden="ASC";
				$flecha="ordenarup.gif";
			}else{
				$orden="DESC";
				$flecha="ordenarinf.gif";
			}
			//Si coinciden campo con el elemento del array
			//la cabecera tendra un color distinto2
			echo '	<td width="' . $tamanos[$i] . '" ><a class="link-tabla" href="#" onclick="f_ordenarPor(' . "'".$campos[$i]."','".$orden."'" . ",'".$pagina."','" .$modulo. "','" .$filtro. "'". ')"><img src="images_grilla/' . $flecha. '" border="0"/>&nbsp;' . utf8_decode($cabecera[$i]). "</a></td>";
		}else{
			$flecha = "ordenar.gif";
			echo '	<td width="' . $tamanos[$i] . '" ><a class="link-tabla" href="#" onclick="f_ordenarPor(' .  "'" .$campos[$i]."','".$orden."'" . ",'".$pagina."','" .$modulo. "','" .$filtro. "'". ')"><img src="images_grilla/' . $flecha. '" border="0" />&nbsp;' .utf8_decode($cabecera[$i]). "</a></td>";
		}
		$i++;
	}
		
	//echo '<td width="' . $tamanos[$i] . '" >' .utf8_decode($cabecera[$i]). "</td>";
	echo '</tr></table>';
		
	echo '<div id="contenido_grilla">';	
		echo '<table border="0" align="center" cellpadding="2" cellspacing="2" class="tabla-realizado">';
		
		//Esta funcion permite comparar el campo actual y el nombre de 
		//la columna en la base de datos
		//mostramos los resultados mediante la consulta de arriba
		
		while($MostrarFila=mysql_fetch_array($resultado)){
		
			echo '<tr OnMouseOver="this.className=' . "'tabla-celdas-over'" . ';"'; 

				if($MostrarFila["status"] == 0){
					echo 'style="color: red; text-decoration:line-through;" ';
				}

				echo 'onMouseOut="this.className=' . "'tabla-celdas'" . ';">';

				echo '	<td width="' . $tamanos[0] . '" class="td-linea">'.htmlentities($MostrarFila["first_name"])."&nbsp;</td>";
				echo '	<td width="' . $tamanos[1] . '" class="td-linea">'.htmlentities($MostrarFila["last_name"])."&nbsp;</td>";
				echo '	<td width="' . $tamanos[2] . '" class="td-linea">'.htmlentities($MostrarFila["dni"])."&nbsp;</td>";
				echo '	<td width="' . $tamanos[3] . '" class="td-linea">'.$MostrarFila["email"]."&nbsp;</td>";
				
				if($MostrarFila["socio"] == 1) $socio = "Si (ASAM)";
				elseif($MostrarFila["socio"] == 2) $socio = "Si (AMCS)";
				else $socio = "No";
				echo '	<td width="' . $tamanos[4] . '" class="td-linea">'.$socio."&nbsp;</td>";

				echo '	<td width="'.$tamanos[5].'" class="td-linea" style="text-align:center">';

				//Visualizar
				echo '<a href="customer.php?action=3&id='.$MostrarFila["id"].'#go"><img src="images_grilla/consulta.gif" title="Visualizar" width="16" height="16" border="0"></a>&nbsp;';		
				
				//Modificar
				echo '<a href="customer.php?action=2&id='.$MostrarFila["id"].'#go"><img src="images_grilla/modificar.gif" title="Modificar" width="16" height="16" border="0"></a>&nbsp;';		

				//Eliminar
				echo '<a href="customer_del.php?id='.$MostrarFila["id"].'" onclick="return confirm('."'"."&iquest;Est&aacute; seguro que desea Eliminar este registro?"."'".');"><img src="images_grilla/eliminar.gif" title="Eliminar" width="16" height="16" border="0"></a>';	
				
				if($obj->f_checkPago($MostrarFila["id"]) == 1){
					echo '&nbsp;<img src="images/green.png" title="Realizo el pago" width="16" height="16" border="0" />';
				}else{
					echo '&nbsp;<img src="images/red.png" title="No realizo el pago" width="16" height="16" border="0" />';
				}

				echo '</td>';
			echo "</tr>";		
		}		
		echo '</table>';
	echo '</div>';
	
	//Linea de paginacion
	echo '<br /><table><tr><td class="verda12"><span style="color: gray">P&aacute;gina</span> ';
		if ($total_paginas > 1){
			for ($i=1;$i<=$total_paginas;$i++){
				if ($pagina == $i) 
					//Si muestro el indice de la pagina actual, no coloco enlace
					echo  $pagina . '&nbsp;';
				else
					//Si el indice no corresponde con la pagina mostrada actualmente, coloco el enlace para ir a esa pagina
					echo '<a href="#" class="verda10" onclick="f_ordenarPor(' . "'".$campo."','".$orden."'" . ",'".$i."','" .$modulo. "','" .$filtro. "'". ')">' . $i . '</a>&nbsp;';		
			
			}
		}else{
			echo '1&nbsp;';
		}
	echo '</td></tr></table><br>';
}else{
	echo '<div class="verda12" style="color:#333">Oups! No se encontraron resultados...</div>';
}
?>