<?php

function getRecipes($pdo, $limit = null)
{
    $sql = 'SELECT * FROM recipes ORDER BY id DESC';
    if ($limit) {
        $sql .= ' LIMIT :limit';
    }

    $query = $pdo->prepare($sql);

    if ($limit) {
        $query->bindValue(':limit', $limit, $pdo::PARAM_INT);
    }
    

    $query->execute();
    
    return $query->fetchAll();

}


function getRecipeById(PDO $pdo, int $id) {
    
    $query = $pdo->prepare("SELECT * FROM recipes WHERE id = :id");
    $query->bindValue(':id', $id, $pdo::PARAM_INT);
    $query->execute();
    $recipe = $query->fetch();

    return $recipe;
}


function deleteRecipe(PDO $pdo, int $id) {
    
    $query = $pdo->prepare("DELETE FROM recipes WHERE id = :id");
    $query->bindValue(':id', $id, $pdo::PARAM_INT);

    $query->execute();
    if ($query->rowCount() > 0) {
        return true;
    } else {
        return false;
    }
}



function saveRecipe(PDO $pdo, string $title, string $description, string $ingredients, string $instructions, string|null $image, int $category_id, int $id = null) {
    if ($id === null) {
        $query = $pdo->prepare("INSERT INTO recipes (title, description, ingredients, instructions, image, category_id) "
        ."VALUES(:title, :description, :ingredients, :instructions, :image, :category_id)");
    } else {
        $query = $pdo->prepare("UPDATE `recipes` SET `title` = :title, "
        ."`description` = :description, `ingredients` = :ingredients, "
        ."`instructions` = :instructions, "
        ."image = :image, category_id = :category_id WHERE `id` = :id;");
        
        $query->bindValue(':id', $id, $pdo::PARAM_INT);
    }

    $query->bindValue(':title', $title, $pdo::PARAM_STR);
    $query->bindValue(':description', $description, $pdo::PARAM_STR);
    $query->bindValue(':ingredients', $ingredients, $pdo::PARAM_STR);
    $query->bindValue(':instructions',$instructions, $pdo::PARAM_STR);
    $query->bindValue(':image',$image, $pdo::PARAM_STR);
    $query->bindValue(':category_id',$category_id, $pdo::PARAM_INT);
    return $query->execute();  
}
