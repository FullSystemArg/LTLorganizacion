<?php
require_once("class/functions.class.php");

if(!isset($_SESSION['id_users'])){
	header("location: login.php");
}else{
	header("location: customer.php");
}
