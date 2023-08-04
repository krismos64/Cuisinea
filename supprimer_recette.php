<?php
require_once('templates/header.php');
require_once('lib/pdo.php');
require_once('lib/tools.php');
require_once('lib/recipe.php');


$recipe = false;
$errors = [];
$messages = [];
if (isset($_GET['id'])) {
    $recipe =  getRecipeById($pdo, $_GET['id']);
}
if ($recipe) {
    if (deleteRecipe($pdo, $_GET['id'])) {
        $messages[] = 'La recette a bien été supprimée';
    } else {
        $errors[] = 'Une erreur s\'est produite lors de la suppression';
    }
} else {
    $errors[] = 'La recette n\'existe pas';
}
?>
<div class="row text-center my-5">
    <h1>Supression recette</h1>
    <?php foreach ($messages as $message) { ?>
        <div class="alert alert-success" role="alert">
            <?= $message; ?>
        </div>
    <?php } ?>
    <?php foreach ($errors as $error) { ?>
        <div class="alert alert-danger" role="alert">
            <?= $error; ?>
        </div>
    <?php } ?>
</div>

<?php
require_once('templates/footer.php');
