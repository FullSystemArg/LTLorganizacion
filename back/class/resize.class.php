<?php
/**
* Creación de thumbnails ( creación de imágenes en miniatura )
*
*/
class Imagenes
{
//Propiedades de la clase
private $_imagen;
private $_formato = 'jpg';
private $_nuevaImagen;
private $_compresion = 90;
private $_nombre;

/**
* Verificar si la libreria GD esta instalada.
*/
public function __construct()
{
$gd=gd_info();

foreach ($gd as $key => $valor)
{
if(!$valor) {
return 'La libreria GD no esta disponible.';
}
}
}

/**
* Indicar a la clase con que imagen vamos a trabajar, es decir, a que
* imagen le vamos a crear un thumbnails.
*/
public function setImagen($urlImagen)
{
$this->_imagen = $urlImagen;
}

/*
* Indicar el formato de que tiene la imagen. La indicada en el
* método "setImagen".
*/
public function setFormato($ext)
{
switch($ext)
{
case "jpeg":
$this->_imagen = imagecreatefromjpeg($this->_imagen);
$this->_formato = $ext;
break;

case "jpg":
$this->_imagen = imagecreatefromjpeg($this->_imagen);
$this->_formato = $ext;
break;

case "png":
$this->_imagen = imagecreatefrompng($this->_imagen);
$this->_formato = $ext;
break;

default : return "Formato de imagen NO soportado.[jpeg|jpg|png]";
}
} 

/**
* Obtener el ancho (width) de la imagen.
*/
public function getImagenX()
{
return imagesx($this->_imagen);
}

/**
* Obtener el alto (height) de la imagen.
*/
public function getImagenY()
{
return imagesy($this->_imagen);
}

/**
* Nivel de compresión de la nueva imagen.
* Máximo 100.
* Cuanto mayor sea este valor mejor sera la calidad,
* pero tambien aumentara el tamaño.
*/
public function setCompresion($compresion)
{
$this->_compresion = $compresion;
}

/**
* Idicar nombre y ruta para la nueva imagen.
*/
public function setNombre($nombre)
{
$this->_nombre = $nombre;
}

/**
* Redimensionar imagen.
* Este método recibe el ancho (x) y el alto (y) que tendra
* la nueva imagen.
* Si $y no se indica, este se añadira con un ancho proporcinal.
*/
public function reducir($x, $y)//$y = 0
{
if($y == 0) {
//Obtener el alto proporcionalmente.
$y = imagesy($this->_imagen) * $x;
$y = $y / imagesx($this->_imagen);
}

if($x == 0) {
//Obtener el alto proporcionalmente.
$x = imagesx($this->_imagen) * $y;
$x = $x / imagesy($this->_imagen);
}

$this->_nuevaImagen = imagecreatetruecolor($x, $y);

imagecopyresampled($this->_nuevaImagen,
$this->_imagen,
0,
0,
0,
0,
$x,
$y,
imagesx($this->_imagen),
imagesy($this->_imagen));

switch($this->_formato)
{
case "jpeg": imagejpeg($this->_nuevaImagen,$this->_nombre,$this->_compresion);
break;

case "jpg": imagejpeg($this->_nuevaImagen,$this->_nombre,$this->_compresion);
break;

case "png": imagepng($this->_nuevaImagen,$this->_nombre,$this->_compresion);
break;

default : return "Formato de imagen NO soportado.[jpeg|jpg|png]";
break;
}
}
}
?>