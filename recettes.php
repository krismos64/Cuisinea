<?php
require_once 'lib/config.php';
require_once 'lib/pdo.php';
require_once 'lib/recipe.php';

require_once 'templates/header.php';


$recipes = getRecipes($pdo);

?>

<h1>Liste des recettes</h1>

<div class="row text-center">
    <?php foreach ($recipes as $key => $recipe) {
        require 'templates/recipe_part.php';
    } ?>

</div>


<?php

require_once 'templates/footer.php';
?>