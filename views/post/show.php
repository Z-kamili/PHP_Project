<?php

use App\database\DataProvider;
use App\Model\Category;
use App\Model\Post;
use App\Table\PostTable;
use App\Table\Table;

$title = "good";

$id =  (int)$params['id'];

$slug = $params['slug'];

$data =  new DataProvider();

$pdo  = $data->connection();

$table = new Table($pdo);

$_table = new PostTable($pdo);

/** @var Post|false */

$post = $_table->find($id);

if($post->getSlug() !== $slug) {

    $url = $router->url('post', ['slug' => $post->getSlug(),'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);

} 

$categories = $table->FindPostCategories($post);

$data->disconnect($pdo);
 
?>

<h1> <?= htmlentities($post->getName()) ?> </h1>

<p class="text-muted"> <?= $post->getCreated_at()->format('d m Y') ?> </p>

<?php foreach($categories as $k => $category) : ?>

    <a href=" <?= $router->url('category',['id' => $category->getID(), 'slug' => $category->getSlug()]) ?> "> <?= $category->getName() ?> </a>

<?php endforeach ?>

<p> <?= $post->getContent() ?> </p>