<?php
//incluimos los archivos php que estaremos utilizando
include 'layout\layout.php';
include 'helpers\utilities.php';
require_once 'Pokemon\pokemon.php';
require_once 'services\IServiceBase.php';
require_once 'Pokemon\CharacterService.php';
require_once 'Races\RaceService.php';
require_once 'Regiones/RegionService.php';

$layout = new Layout(false);
$utilities = new Utilities();
$service = new CharacterService();
$raceService = new RaceService();
$regionService= new RegionService();


//Obtenemos el listado actual de personaje almacenado en la session
$listadoPokemon = $service->GetList();
$filterName = "";

if (isset($_GET["name"])) {
    $filterName = $_GET["name"];
}

?>

<?php $layout->printHeader(); ?>

<!-- Begin page content -->
<main role="main" class="flex-shrink-0">
    <div class="container">

        <?php if (empty($listadoPokemon)) : ?>
       
        <div style="margin-top: 10%;margin-bottom: 7%; " class="card">
        <div class="card-header text-white bg-dark " >
            <h2>No hay Pokemon registrado, <a href="Pokemon/add.php" class="btn btn-primary my-2"><i class="fa fa-plus-square"></i> Agregar nuevo Pokemon</a> </h2>

        <?php else : ?>
            <div style="margin-top: 3%;" class="row">

                <div class="col-md-4">

                    <div class="card">
                        <div class="card-header bg-dark text-white">
                            Filtros
                        </div>
                        <div class="card-body">

                            <form method="GET" action="index.php">
                                <div class="form-group">
                                    <label for="nameInput">Nombre</label>
                                    <input type="text" value="<?php echo $filterName; ?>" name="name" class="form-control" id="nameInput">

                                </div>


                                <div class="form-group">
                                    <label for="raceInput"> Tipo de Pokemon </label>

                                    <select name="raceId" class="form-control" id="raceInput">

                                        <?php foreach ($regionService->GetList() as $region) : ?>
                                            <option value="<?php echo $region->id ?>"><?php echo $region->name ?></option>
                                        <?php endforeach; ?>

                                    </select>

                                </div>

                                <div class="form-group">
                                    <label for="regionInput"> Region </label>
                                    <select name="regionId" class="form-control" id="regionInput">

                                    <?php foreach ($raceService->GetList() as $race) : ?>
                                            <option value="<?php echo $race->id ?>"><?php echo $race->name ?></option>
                                        <?php endforeach; ?>

                                    </select>

                                </div>


                                <button type="submit" class="btn btn-primary"> <i class="fa fa-search" aria-hidden="true"></i> Buscar</button>
                            </form>

                        </div>
                    </div>

                </div>

                <div class="col-md-8">
                    <?php $i = 1; ?>
                    <?php foreach ($listadoPokemon as $pokemon) : ?>

                        <?php if ($i == 1) : ?>
                            <div class="row">
                            <?php endif; ?>
                            <div class="col-md-6">
                                <div class="card mb-6 shadow-sm">

                                    <img class="bd-placeholder-img card-img-top" src="<?php echo "Pokemon/" . $pokemon->profilePhoto; ?>" width="100%" height="225" alt="">

                                    <div class="card-body">
                                        <p class="card-text"><strong> <?php echo $pokemon->name; ?> </strong></p>
                                        <div class="d-flex justify-content-between align-items-center">

                                            <div class="btn-group">
                                                <a href="Pokemon/details.php?id=<?php echo $pokemon->id ?>" class="btn text-white btn-sm btn-outline-secondary btn-primary"><i class="fa fa-info-circle" aria-hidden="true"></i> Detalle</a>
                                                <a href="Pokemon/edit.php?id=<?php echo $pokemon->id ?>" class="btn text-white btn-sm btn-outline-secondary btn-warning"> <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Editar</a>
                                                <a href="Pokemon/delete.php?id=<?php echo $pokemon->id ?>" class="btn text-white btn-sm btn-outline-secondary btn-danger"><i class="fa fa-trash-o" aria-hidden="true"></i> Eliminar</a>
                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php if ($i == 2) : ?>
                            </div>

                            <?php $i = 1; ?>
                        <?php else : ?>
                            <?php $i += 1; ?>
                        <?php endif; ?>


                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

    </div>
</main>


<?php $layout->printFooter(); ?>


</body>

</html>