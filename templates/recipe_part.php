<div class="col-md-4 my-2">
    <div class="card">
        <?php
            if ($recipe['image'] == null) {
                $imagePath = _ASSETS_IMAGES_FOLDER_.'recipe_default.jpg';
            } else {
                $imagePath = _RECIPES_FOLDER_ . $recipe['image'];
            }
        ?>

        <img src="<?=$imagePath ; ?>" class="card-img-top" alt="<?= $recipe['title']; ?>">
        <div class="card-body">
            <h5 class="card-title"><?= $recipe['title']; ?></h5>
            <p class="card-text"><?= $recipe['description']; ?></p>
            <a href="recette.php?id=<?=$recipe['id']; ?>" class="btn btn-primary">Voir la recette</a>
            <a class="btn text-success btn-outline-primary" href="ajout_modification_recette.php?id=<?=$recipe['id']; ?>"><i class="bi bi-pencil-square"></i></a>
            <a class="btn text-danger btn-outline-primary" href="supprimer_recette.php?id=<?=$recipe['id']; ?>" onclick="return confirm('Souhaitez-vous supprimer cette recette');"><i class="bi bi-trash3-fill"></i></a>
        </div>
    </div>
</div>