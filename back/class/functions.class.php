<?php
include_once("conector_database.class.php");

class oFunctions extends oConectorDB
{
	
	public $is_logged_in	=false;
	public $id_users;
	public $path_file 		= "back/upload_files/";
	public $company_email 	= "info@ltlorganizacion.com.ar";
	public $company_name 	= "LTLorganizacion";
	public $company_page 	= "http://www.ltlorganizacion.com.ar";
	public $path_absolute	= "/home/dgd32s32/public_html";

	function __construct() {
		$this->oConectorDB();
		session_start();
	}
	
	function sendEmail($from_email, $from_name, $to_email, $to_name, $subject, $msg){
		//Envío en formato HTML 
		$headers	 = 'MIME-Version: 1.0' . "\r\n"; 
		$headers 	.= 'Content-type: text/html; charset=iso-8859-1' . "\r\n"; 
		$headers	.= "From: <" . $from_email . "> " . $from_name . " \r\n"; 
		$headers 	.= "Reply-To: <" . $from_email . "> \r\n";
		mail($to_email, $subject, $msg, $headers);		
	}

	function cortaCadena($cadena){
		$array = explode(" ",$cadena);
		$subArray = array();
		for($i=0 ; $i <= 8; $i++){
		$subArray[$i] = $array[$i];
		$cadena = implode(" ",$subArray);
		}
		return $cadena;
	}
	function aURL($cadena) {

		$buscados=array(" ","á","é","í","ó","ú","ñ","ç","&");
		$sustitut=array("-","a","e","i","o","u","n","c","y");
		$final = eregi_replace("[^a-z0-9_-]", "", str_replace($buscados,$sustitut, strtolower($cadena)));

		return $final;
	}

	function ImageTypeAndSize($w = 650 , $h = 400,$img = 'img'){
			global $database;
			$file= $_FILES[$img];
			if(!$file || empty($file) || !is_array($file)){
				return FALSE;			
			}else{
				$tmp_name = $file['tmp_name'];
				$target_file = basename($file['name']);
				$ext = explode(".",$target_file);
				$extension = $ext[count($ext)-1];
				if($extension == "jpg" || $extension == "jpeg" || $extension == "gif" || $extension == "png"){
					list($width, $height, $type, $attr) = GetImageSize($tmp_name);
					if($width <= $w && $height <=$h){
						return TRUE;
					}else{
						return FALSE;
					}
				}else{
					return FALSE;
				}			
			}				
	}

	function stringcut($cadena,$num){
		$array = explode(" ",$cadena);
		$subArray = array();
		for($i=0 ; $i <= $num; $i++){
		$subArray[$i] = $array[$i];
		$cadena = implode(" ",$subArray);
		}
		return $cadena;
	}
	function isEmail($email){
		if (preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$email)){
			return true;
		}else{
			return false;
		}
	}

	function resize($img = 'img',$name=""){
		
		$path = "../productos/";
		$dir = opendir($path);
				
		$file= $_FILES[$img];
		if(!$file || empty($file) || !is_array($file)){
			return FALSE;			
		}else{
			$tmp_name = $file['tmp_name'];
			$target_file = basename($file['name']);
			$ext = explode(".",$target_file);
			$extension = strtolower($ext[count($ext)-1]);
			switch($extension){
				case "jpg":
					$img = imagecreatefromjpeg( $tmp_name );
					$width = imagesx( $img );
					$height = imagesy( $img );
					echo $width;
					echo "x".$height;
					$new_width = 300;
					$new_height = ($new_width * $height)/$width;
					$tmp_img = imagecreatetruecolor( $new_width, $new_height);
					$color = imagecolorallocate($tmp_img, 255, 255, 255);
					imagefill($tmp_img,0, 0,$color);
					imagecopyresized( $tmp_img, $img, 0, 0, 0,0 , $new_width, $new_height, $width, $height );
					imagejpeg( $tmp_img, $path.$name );
					return TRUE;
					break;
				case "gif":
					$width = imagesx( $img );
					$height = imagesy( $img );
					echo $width;
					echo "x".$height;
					$new_width = 300;
					$new_height = ($new_width * $height)/$width;
					$tmp_img = imagecreatetruecolor( $new_width, $new_height);
					$color = imagecolorallocate($tmp_img, 255, 255, 255);
					imagefill($tmp_img,0, 0,$color);
					imagecopyresized( $tmp_img, $img, 0, 0, 0,0 , $new_width, $new_height, $width, $height );
					imagejpeg( $tmp_img, $path.$name );
					return TRUE;
					break;
				case "png":	
					$width = imagesx( $img );
					$height = imagesy( $img );
					echo $width;
					echo "x".$height;
					$new_width = 300;
					$new_height = ($new_width * $height)/$width;
					$tmp_img = imagecreatetruecolor( $new_width, $new_height);
					$color = imagecolorallocate($tmp_img, 255, 255, 255);
					imagefill($tmp_img,0, 0,$color);
					imagecopyresized( $tmp_img, $img, 0, 0, 0,0 , $new_width, $new_height, $width, $height );
					imagejpeg( $tmp_img, $path.$name );
					return TRUE;
					break;
				default:
					return FALSE;
			}
		}					
	}
	function loggin(){
		$password = sha1($_POST['password']);		
		$query = "SELECT * FROM tbl_users";	
		$rowSQL = mysql_fetch_array(mysql_query($query));
		
		if("admin" == $rowSQL["username"] && $password == $rowSQL["password"]){
			$_SESSION['id_users'] = 1 ;
			header("location: customer.php");
		}else{
			return $error = "&nbsp;&nbsp;-&nbsp;Error al ingresar al sistema.<br />&nbsp;&nbsp;-&nbsp;Nombre de Usuario/Password incorrectos";
			//header("location: login.php");
		}
	}

	function isLoggedIn(){
		
		if(!isset($_SESSION['id_users'])){
			header("location: login.php");
		}else{
			return true;
		}
		
	}
}
$oFunctions = new oFunctions();
?>
