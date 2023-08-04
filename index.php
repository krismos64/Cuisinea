<?php

require_once 'lib/config.php';
require_once 'lib/pdo.php';
require_once 'lib/recipe.php';

require_once 'templates/header.php';

$recipes = getRecipes($pdo, 3);

?>

            <div class="px-4 py-5 my-5 text-center">
                <img class="d-block mx-auto mb-4" src="assets/images/logo-cuisinea.jpg" alt="Logo Cuisinea" width="350">
                <h1 class="display-5 fw-bold">Cuinea | Recettes faciles</h1>
                <div class="col-lg-6 mx-auto">
                    <p class="lead mb-4">Quickly design and customize responsive mobile-first sites with Bootstrap, the world’s most popular front-end open source toolkit, featuring Sass variables and mixins, responsive grid system, extensive prebuilt components, and powerful JavaScript plugins.</p>
                    <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <a href="recettes.php" class="btn btn-primary">Voir toutes nos recettes</a>
                    </div>
                </div>
            </div>


            <div class="row text-center">
                <?php foreach ($recipes as $key => $recipe) { 
                    require 'templates/recipe_part.php';
                } ?>

            </div>


<?php
    require_once 'templates/footer.php';
?>