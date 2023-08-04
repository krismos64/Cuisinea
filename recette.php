<?php
require_once 'lib/config.php';
require_once 'lib/tools.php';
require_once 'lib/pdo.php';
require_once 'lib/recipe.php';

require_once 'templates/header.php';

$id = (int)$_GET['id'];

$recipe = getRecipe($pdo, $id);

if ($recipe) {
    if ($recipe['image'] == null) {
        $imagePath = _ASSETS_IMAGES_FOLDER_.'recipe_default.jpg';
    } else {
        $imagePath = _RECIPES_FOLDER_ . $recipe['image'];
    }


    ?>

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <div class="col-10 col-sm-8 col-lg-6">
            <img src="<?=$imagePath;  ?>" class="d-block mx-lg-auto img-fluid" alt="<?= $recipe['title'];  ?>" width="700" height="500" loading="lazy">
        </div>
        <div class="col-lg-6">
            <h1 class="display-5 fw-bold lh-1 mb-3"><?= $recipe['title'];  ?></h1>
            <p class="lead"><?= $recipe['description'];  ?></p>
        </div>
    </div>

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <h2>Ingrédients</h2>
        <?php
        $ingredients = linesToArray($recipe['ingredients']);
    ?>
        <ul class="list-group">
            <?php foreach ($ingredients as $key => $ingredient) { ?>
                <li class="list-group-item"><?= $ingredient; ?></li>
            <?php } ?>
        </ul>


    </div>

    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
        <h2>Instructions</h2>
        <?php
    $instructions = linesToArray($recipe['instructions']);

    ?>
        <ol class="list-group list-group-numbered">
            <?php foreach ($instructions as $instruction) { ?>
                <li class="list-group-item"><?= $instruction; ?></li>
            <?php } ?>
            </ul>
    </div>

<?php } else { ?>
    <div class="row text-center my-5">
        <h1>Recette introuvable</h1>
    </div>
<?php } ?>



<?php
require_once 'templates/footer.php';
?>