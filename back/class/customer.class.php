<?php
include_once("conector_database.class.php");

Class Customer extends oConectorDB
{
	public $id;
	public $first_name;
	public $last_name;
	public $dni;
	public $email;
	public $id_area;
	public $id_category;
	public $socio;
	public $password;
	public $status;
	public $confirm_email;
	public $date;
	
	// Constructor
	function __construct(){
		$this->oConectorDB();
	}

	function f_nuevoSQL($first_name, $last_name, $dni, $email, $id_area, $id_category, $socio, $password, $status, $confirm_email){					
		$sql = "INSERT INTO tbl_customer VALUES ('','$first_name', '$last_name', '$dni', '$email', $id_area, $id_category, '$socio', '$password', '$status', '$confirm_email', now())";
		$r=mysql_query ($sql) or die (mysql_error());			
		$insertado = mysql_insert_id();
		if($insertado>0)return $insertado;		
	}
	
	function f_modificarSQL($id, $first_name, $last_name, $dni, $email, $id_area, $id_category, $socio, $password, $status, $confirm_email){		
		$sql = "UPDATE tbl_customer SET first_name = '$first_name', last_name = '$last_name', dni = '$dni', email = '$email', id_area = $id_area, id_category = $id_category, socio = '$socio', password = '$password', status = '$status', confirm_email = '$confirm_email' WHERE id = '$id'";
		$r=mysql_query ($sql) or die (mysql_error());
	}
	
	function f_eliminarSQL($id){			
		$sql = "DELETE FROM tbl_customer WHERE id = '$id'";
		$r=mysql_query ($sql) or die (mysql_error());
	}
	
	function f_darCantCustomerSQL($filtro) {
		$sql = "SELECT tbl_customer.*, area.description as area_description, category.description as category_description  
				FROM tbl_customer
				LEFT JOIN tbl_area area ON tbl_customer.id_area = area.id
				LEFT JOIN tbl_category category ON tbl_customer.id_category = category.id
				" . $filtro;	
		$r=mysql_query ($sql) or die (mysql_error());
		$total = mysql_num_rows($r);		
		return $total;		
	}
	
	function f_darCustomerSQL($filtro,$campo,$orden,$inicio,$tamano_pagina) {	
		$sql = "SELECT tbl_customer.*, area.description as area_description, category.description as category_description  
				FROM tbl_customer
				LEFT JOIN tbl_area area ON tbl_customer.id_area = area.id
				LEFT JOIN tbl_category category ON tbl_customer.id_category = category.id
				" . $filtro . " ORDER BY " . $campo . " " . $orden .  " LIMIT " . $inicio . "," . $tamano_pagina;
		$r=mysql_query ($sql) or die (mysql_error());
		return $r;			
	}	
	
	function f_darCustomerRowSQL($id) {				
		$sql = "SELECT tbl_customer.*, area.description as area_description, category.description as category_description 
				FROM tbl_customer
				LEFT JOIN tbl_area area ON tbl_customer.id_area = area.id
				LEFT JOIN tbl_category category ON tbl_customer.id_category = category.id
				WHERE tbl_customer.id = '$id'";
		$r=mysql_query ($sql) or die (mysql_error());
		$result = mysql_fetch_array($r);
		return $result;		
	}

	function f_nuevoFileSQL($id_user, $file, $type){				
		$sql = "INSERT INTO tbl_file VALUES ('', '$id_user', '$file', '$type', now())";
		$r=mysql_query ($sql) or die (mysql_error());			
		$insertado = mysql_insert_id();
		if($insertado>0)return $insertado;		
	}

	function f_darFileByType($id_user, $type) {	
		$sql = "SELECT *
				FROM tbl_file WHERE id_user = " . $id_user . " AND type = " . $type;
		$r=mysql_query ($sql) or die (mysql_error());
		return $r;			
	}

	function f_darFileById($id) {	
		$sql = "SELECT *
				FROM tbl_file WHERE id = $id";
		$r=mysql_query ($sql) or die (mysql_error());;
		$result = mysql_fetch_array($r);
		return $result;		
	}

	function f_darFilesByUser($id_user) {	
		$sql = "SELECT *
				FROM tbl_file WHERE id_user = " . $id_user;
		$r=mysql_query ($sql) or die (mysql_error());
		return $r;	
	}

	function f_eliminarFileSQL($id){			
		$sql = "DELETE FROM tbl_file WHERE id = '$id'";
		$r=mysql_query ($sql) or die (mysql_error());		
	}	

	function f_darPriceByCategoriaAndSocio($c, $s){
		if($s == 0){
			$sql = "SELECT importe_nosocios FROM tbl_category WHERE id = $c";
		}else{
			$sql = "SELECT importe_socios FROM tbl_category WHERE id = $c";
		}
		$r=mysql_query ($sql) or die (mysql_error()); 
		$result = mysql_fetch_array($r);
		return $result[0];
	}

	function f_checkExistsUser($email, $id = null){
		if($id != null) $sql = "SELECT 1 FROM tbl_customer WHERE id != $id AND email = '" . $email . "' LIMIT 0,1";	
		else $sql = "SELECT 1 FROM tbl_customer WHERE email = '" . $email . "'";
		
		$r=mysql_query ($sql) or die (mysql_error()); 
		return mysql_num_rows($r);
	}

	function f_darCustomerRowByEmailSQL($email) {				
		$sql = "SELECT first_name, last_name, id, password
				FROM tbl_customer
				WHERE email = '$email'";
		$r=mysql_query ($sql) or die (mysql_error());
		$result = mysql_fetch_array($r);
		return $result;		
	}

	function f_checkLogin($email, $password) {				
		$sql = "SELECT 1 FROM tbl_customer WHERE email = '" . $email . "' AND password = '" . $password . "' AND status = 1 AND confirm_email = 1 LIMIT 0,1";
		$r=mysql_query ($sql) or die (mysql_error()); 
		return mysql_num_rows($r);	
	}

	function f_checkSession(){
		if(isset($_SESSION['user_congreso'])){
			return true;
		}else{
			return false;
		}
	}

	function f_generateSession($id, $first_name, $last_name, $email){
		if(!isset($_SESSION['user_congreso'])){
			$_SESSION['user_congreso'] = array(
												'id' 			=> $id,
												'first_name' 	=> $first_name,
												'last_name'		=> $last_name,
												'email'			=> $email
											);
			return $_SESSION['user_congreso'];
		}else{
			return false;
		}
	}

	function f_checkPago($id) {				
		$sql = "SELECT 1 FROM tbl_file WHERE id_user = $id AND type = 1 LIMIT 0,1";
		$r=mysql_query ($sql) or die (mysql_error()); 
		return mysql_num_rows($r);	
	}


	function f_checkValidateUser($id) {				
		$sql = "SELECT 1 FROM tbl_customer WHERE id = $id AND confirm_email = 0 AND status = 0 LIMIT 0,1";
		$r=mysql_query ($sql) or die (mysql_error()); 
		return mysql_num_rows($r);	
	}

	function f_generateValidateUser($id) {				
		$sql = "UPDATE tbl_customer SET status = 1, confirm_email = 1 WHERE id = '$id'";
		$r=mysql_query ($sql) or die (mysql_error());
	}

}

$obj = new Customer();
?>