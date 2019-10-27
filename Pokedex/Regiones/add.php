<?php
//incluimos los archivos php que estaremos utilizando

require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'region.php';
require_once '../services\IServiceBase.php';
require_once 'RegionService.php';

$layout = new Layout(true);
$utilities = new Utilities();
$service = new RegionService();

//Validamos si existen valores en la variable de $_POST 
if (isset($_POST['name'])) {

  
    $newRegion = new Region();

    $newRegion->InitializeData(0, $_POST['name']);

    $service->Add($newRegion);

    header("Location: list.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}

?>

<?php $layout->printHeader(); ?>

<main role="main">

<div style="margin-top: 10%;margin-bottom: 7%; " class="card">
        <div class="card-header text-white bg-dark " >
            Registre nueva Region de Pokemon
        </div>
        <div class="card-body">


            <form method="POST" action="add.php" enctype="multipart/form-data">

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="InputName">Nombre</label>
                        <input type="text" name="name" class="form-control" id="InputName" placeholder="Introduzca el nombre del pokemon ">

                    </div>
                </div>    

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Crear Region</button>
            </form>

        </div>
    </div>

</main>

<?php $layout->printFooter(); ?>