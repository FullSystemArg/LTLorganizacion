<?php
class oConectorDB {

	public $server;
	public $usuario;
	public $password;
	public $db;
	
	// Constructor
	public function oConectorDB(){
		$this->server 		= "localhost";
		$this->usuario 		= "dgd32s32_ltl";
		$this->password 	= "c0j904loop1QK1";
		$this->db 			= "dgd32s32_congreso";
		
		mysql_connect($this->server,$this->usuario,$this->password);
		mysql_select_db($this->db);
	}
	public function f_cerrarSQL() {	
		mysql_close($links);
	}
}
?>