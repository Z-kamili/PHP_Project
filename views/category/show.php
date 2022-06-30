<?php

use App\database\DataProvider;
use App\Model\Category;
use App\Model\Post;

$title = "Category";

$id =  (int)$params['id'];

$slug = $params['slug'];

$data =  new DataProvider();

$pdo  = $data->connection();

$query =  $pdo->prepare('SELECT * FROM category WHERE id = :id');

$query->execute(['id' => $id]);

$query->setFetchMode(PDO::FETCH_CLASS , Category::class);

/** @var Post|false */

$category = $query->fetch();

if($category === false) {

    throw new Exception('Aucun category ne correspond à cet ID');

}

if($category->getSlug() !== $slug) {

    $url = $router->url('category', ['slug' => $category->getSlug(),'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);

} 


$title = "Catégorie {$category->getName()}";

?>

<h1> <?= $title ?> </h1>


<h1>Ma category</h1>


