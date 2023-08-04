<?php
require_once('templates/header.php');
require_once('lib/config.php');
require_once('lib/tools.php');
require_once('lib/pdo.php');
require_once('lib/recipe.php');

$errors = [];
$messages = [];
$recipe = [
    'title' => '',
    'description' => '',
    'ingredients' => '',
    'instructions' => '',
    'category_id' => ''
];

if (isset($_GET['id'])) {
    //requête pour récupérer les données de la recette en cas de modification
    $recipe = getRecipeById($pdo, $_GET['id']);
    if ($recipe === false) {
        $errors[] = 'La recette n\'existe pas';
    }
    $pageTitle = 'Modifier la recette';
} else {
    $pageTitle = 'Ajouter une recette';
}

if (isset($_POST['saveRecipe'])) {
    $fileName = null;
    // Si un fichier est envoyé
    if (isset($_FILES["file"]["tmp_name"]) && $_FILES["file"]["tmp_name"] != '') {
        $checkImage = getimagesize($_FILES["file"]["tmp_name"]);
        if ($checkImage !== false) {
            $fileName = slugify(basename($_FILES["file"]["name"]));
            $fileName = uniqid() . '-' . $fileName;

            if (move_uploaded_file($_FILES["file"]["tmp_name"], _RECIPES_FOLDER_ . $fileName)) {
                if (isset($_POST['image'])) {
                    // On supprime l'ancienne image si on a posté une nouvelle
                    unlink(_RECIPES_FOLDER_ . $_POST['image']);
                }
            } else {
                $errors[] = 'Le fichier n\'a pas été uploadé';
            }
        } else {
            $errors[] = 'Le fichier doit être une image';
        }
    } else {
        // Si aucun fichier n'a été envoyé
        if (isset($_GET['id'])) {
            if (isset($_POST['delete_image'])) {
                // Si on a coché la case de suppression d'image, on supprime l'image
                unlink(_RECIPES_FOLDER_ . $_POST['image']);
            } else {
                $fileName = $_POST['image'];
            }
        }
    }

    // Si il n'y a pas d'erreur on peut faire la sauvegarde
    if (!$errors) {
        if (isset($_GET['id'])) {
            // Avec (int) on s'assure que la valeur stockée sera de type int
            $id = (int)$_GET['id'];
        } else {
            $id = null;
        }
        // On passe toutes les données à la fonciton saveRecipe
        $res = saveRecipe($pdo, $_POST['title'], $_POST['description'], $_POST['ingredients'], $_POST['instructions'], $fileName, (int)$_POST['category_id'], $id);

        if ($res) {
            $messages[] = 'La recette a bien été sauvegardée';
        } else {
            $errors[] = 'La recette n\'a pas été sauvegardée';
        }
    }
    /* On stocke toutes les données envoyés dans un tableau pour pouvoir afficher
       les informations dans les champs. C'est utile pas exemple si on upload un mauvais
       fichier et qu'on ne souhaite pas perdre les données qu'on avait saisit.
    */
    $recipe = [
        'title' => $_POST['title'],
        'description' => $_POST['description'],
        'ingredients' => $_POST['ingredients'],
        'instructions' => $_POST['instructions'],
        'category_id' => $_POST['category_id'],
        'image' => $fileName
    ];
}

?>
<h1><?=$pageTitle; ?></h1>

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
<?php if ($recipe !== false) { ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="title" class="form-label">Titre</label>
            <input type="text" class="form-control" id="title" name="title" value="<?= $recipe['title']; ?>">
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="3"><?= $recipe['description']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingrédients</label>
            <textarea class="form-control" id="ingredients" name="ingredients" rows="3"><?= $recipe['ingredients']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="instructions" class="form-label">Instructions</label>
            <textarea class="form-control" id="instructions" name="instructions" rows="3"><?= $recipe['instructions']; ?></textarea>
        </div>
        <div class="mb-3">
            <label for="category" class="form-label">Catégorie</label>
            <select name="category_id" id="category" class="form-select">
                <option value="1" <?php if (isset($recipe['category_id']) && $recipe['category_id'] == 1) { ?>selected="selected" <?php }; ?>>Entrée</option>
                <option value="2" <?php if (isset($recipe['category_id']) && $recipe['category_id'] == 2) { ?>selected="selected" <?php }; ?>>Plat</option>
                <option value="3" <?php if (isset($recipe['category_id']) && $recipe['category_id'] == 3) { ?>selected="selected" <?php }; ?>>Dessert</option>
            </select>
        </div>

        <?php if (isset($_GET['id']) && isset($recipe['image'])) { ?>
            <p>
                <img src="<?=_RECIPES_FOLDER_.$recipe['image'] ?>" alt="<?=$recipe['title'] ?>" width="100">
                <label for="delete_image">Supprimer l'image</label>
                <input type="checkbox" name="delete_image" id="delete_image">
                <input type="hidden" name="image" value="<?= $recipe['image']; ?>">
                
            </p>
        <?php } ?>

        <input type="file" name="file" id="file">

        <input type="submit" name="saveRecipe" class="btn btn-primary" value="Enregistrer">

    </form>

<?php } ?>

<?php
require_once('templates/footer.php');
