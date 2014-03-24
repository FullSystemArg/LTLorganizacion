<?php
include_once("conector_database.class.php");

class oConfiguracion extends oConectorDB
	{
		public $id_users;
		public $first_name;
		public $last_name ;
		public $email;
		public $username;
		public $password;
		public $id_profile;
		public $description;
		public $date;
		
		// Constructor
		function __construct(){
			$this->oConectorDB();
		}
			
		function f_comprobarPw($password_ant){		
			$sql = "SELECT 1 FROM tbl_users WHERE password = "."'".$password_ant."'";			
			$r= mysql_query($sql) or die (mysql_error());
			$total = mysql_num_rows($r);
			return $total;
		}
		function f_modificarPw($password){
			$sql = "UPDATE tbl_users set password = "."'".$password."'";
			$r=mysql_query ($sql) or die (mysql_error());
		}
		
}
$oConfiguracion = new oConfiguracion();
?>
