<?php

use App\database\DataProvider;
use App\Model\Post;

$title = "good";

$id =  (int)$params['id'];

$slug = $params['slug'];

$data =  new DataProvider();

$pdo  = $data->connection();

$query =  $pdo->prepare('SELECT * FROM post WHERE id = :id');

$query->execute(['id' => $id]);

$query->setFetchMode(PDO::FETCH_CLASS , Post::class);

/** @var Post|false */

$post = $query->fetch();

if($post === false) {

    throw new Exception('Aucun article ne correspond à cet ID');

}

if($post->getSlug() !== $slug) {

    $url = $router->url('post', ['slug' => $post->getSlug(),'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);


} 

$data->disconnect($pdo);
 




?>

<h1> <?= htmlentities($post->getName()) ?> </h1>
<p class="text-muted"> <?= $post->getCreatedAt()->format('d m Y') ?> </p>
<p> <?= $post->getContent() ?> </p>