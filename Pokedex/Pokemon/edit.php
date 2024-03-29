<?php
//incluimos los archivos php que estaremos utilizando
require_once '../layout/layout.php';
require_once '../helpers/utilities.php';
require_once 'Pokemon.php';
require_once '../services\IServiceBase.php';
require_once 'CharacterService.php';
require_once '../Races/RaceService.php';
require_once '../Regiones/RegionService.php';

$layout = new Layout(true);
$utilities = new Utilities();
$service = new CharacterService();
$raceService = new RaceService();
$regionService= new RegionService();

$containId = isset($_GET['id']); //validamos si hay un parametro id en el query string de la url
$characterId = 0;

$element = [];

if ($containId) {
    $characterId = $_GET['id']; //El Id del pokemon que vamos a editar
    $element = $service->GetById($characterId);
   
}

if (isset($_POST['name']) && isset($_POST['regionId']) && isset($_POST['raceId']) && isset($_POST['techniques'])) { //aqui verificamos si estamos recibiendo valores por $_POST para editar los valores del elemento en el listado de pokemones de la session 

    $techniques = explode(",", $_POST['techniques']);
    $updateCharacter = new Character();
    $updateCharacter->InitializeData($characterId, $_POST['name'], $_POST['regionId'], $_POST['raceId'], $techniques);

    $service->Update($characterId, $updateCharacter);
   

    header("Location: ../index.php"); //enviamos a la pagina principal del website
    exit(); //esto detiene la ejecucion del php para que se realice el redireccionamiento
}
?>


<?php $layout->printHeader(); ?>

<main role="main">

    <?php if ($containId && $element != null) : ?>

        <div style="margin-top: 5%" class="card">
            <div class="card-header bg-warning text-white">
                <strong> Editando el Pokemon <?php echo $element->name ?></strong>
            </div>
            <div class="card-body">

                <form method="POST" enctype="multipart/form-data" action="edit.php?id=<?php echo $element->id ?>">

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="InputName">Nombre</label>
                            <input type="text" name="name" value="<?php echo $element->name ?>" class="form-control" id="InputName" placeholder="Introduzca el nombre ">

                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="regionInput"> Region </label>
                            <select name="regionId" class="form-control" id="regionInput">

                            <?php foreach ($regionService->GetList() as $region) : ?>

                                <?php if ($region->id == $element->regionId) : ?>
                             <option selected value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                                <?php else : ?>
                                    <option value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                                <?php endif; ?>

                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>


                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="raceInput"> Tipo de pokemon </label>
                       
                            <select name="raceId" class="form-control" id="raceInput">

                                <?php foreach ($raceService->GetList() as $race) : ?>

                                    <?php if ($race->id == $element->raceId) : ?>
                                        <option selected value="<?php echo $race->id ?>"><?php echo $race->name ?></option>
                                    <?php else : ?>
                                        <option value="<?php echo $race->id ?>"><?php echo $race->name ?></option>
                                    <?php endif; ?>

                                <?php endforeach; ?>

                            </select>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">

                            <label for="InputTechniques">Poderes</label>
                            <textarea name="techniques" class="form-control" id="InputTechniques" aria-describedby="TechniquesHelp" placeholder="Introduzca las tecnicas "><?php echo $element->getEditableTechniques() ?> </textarea>
                            <small id="TechniquesHelp" class="form-text text-muted">Colocar poderes separados por comas</small>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="characterPhoto">Foto del Pokemon</label>
                            <input type="file" name="profilePhoto" class="form-control-file" id="characterPhoto">

                            <div style="margin-top: 1%" class="card bg-dark" style="width: 18rem;">
                                <img class="bd-placeholder-img card-img-top" src="<?php echo $element->profilePhoto; ?>" width="225" height="225" alt="">
                                <div class="card-body">

                                </div>
                            </div>


                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Guardar Pokemon</button>
                </form>

            </div>
        </div>

    <?php else : ?>

        <h2>No existe</h2>

    <?php endif; ?>

</main>

<?php $layout->printFooter(); ?>