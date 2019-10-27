<?php
//incluimos los archivos php que estaremos utilizando

require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'pokemon.php';
require_once '../services\IServiceBase.php';
require_once 'CharacterService.php';
require_once '../Races/RaceService.php';
require_once '../Regiones/RegionService.php';

$layout = new Layout(true);
$utilities = new Utilities();
$service = new CharacterService();
$raceService = new RaceService();
$regionService= new RegionService();



//Validamos si existen valores en la variable de $_POST 
if (isset($_POST['name']) && isset($_POST['regionId']) && isset($_POST['raceId']) && isset($_POST['techniques'])) {

    $techniques = explode(",", $_POST['techniques']);
    $newCharacter = new Character();

    $newCharacter->InitializeData($characterId, $_POST['name'], $_POST['regionId'], $_POST['raceId'], $techniques);

    $service->Add($newCharacter);

    header("Location: ../index.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}

?>

<?php $layout->printHeader(); ?>

<main role="main">

    <div style="margin-top: 10%;margin-bottom: 7%;" class="card">
        <div class="card-header text-white bg-dark">
            Registra un nuevo pokemon
        </div>
        <div class="card-body">


            <form method="POST" action="add.php" enctype="multipart/form-data">

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="InputName">Nombre</label>
                        <input type="text" name="name" class="form-control" id="InputName" placeholder="Introduzca el nombre ">

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                    <label for="regionInput"> Region </label>
                        <select name="regionId" class="form-control" id="regionInput">

                            <?php foreach ($regionService->GetList() as $region) : ?>
                                <option value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>


                <div class="col-md-4">
                    <div class="form-group">
                        <label for="raceInput"> Tipo de pokemon </label>

                        <select name="raceId" class="form-control" id="raceInput">

                            <?php foreach ($raceService->GetList() as $race) : ?>
                                <option value="<?php echo $race->id ?>"><?php echo $race->name ?></option>
                            <?php endforeach; ?>

                        </select>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">

                        <label for="InputTechniques">Poderes</label>
                        <textarea name="techniques" class="form-control" id="InputTechniques" aria-describedby="TechniquesHelp" placeholder="Introduzca las tecnicas "> </textarea>
                        <small id="TechniquesHelp" class="form-text text-muted">Colocar poderes separados por comas</small>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="characterPhoto">Foto del Pokemon</label>
                        <input type="file" name="profilePhoto" class="form-control-file" id="characterPhoto">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-plus-square"></i> Crear el Pokemon</button>
            </form>

        </div>
    </div>

</main>

<?php $layout->printFooter(); ?>