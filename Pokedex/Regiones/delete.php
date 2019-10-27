<?php
//incluimos los archivos php que estaremos utilizando
require_once '../helpers/utilities.php';
require_once 'region.php';
require_once '../services\IServiceBase.php';
require_once 'RegionService.php';

$service = new RegionService();


$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url
$regionId = 0;


if ($containId) {
    $regionId = $_GET['id']; //El Id del personaje que vamos a editar   
    $service->Delete($regionId);

}

 header("Location: list.php"); //enviamos a la pagina principal del website
 exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento

?>