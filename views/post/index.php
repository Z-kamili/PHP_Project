<?php

use App\Helpers\Text;
use App\Model\Post;

$title = "Mon Blog";

//PDO Initialisation
$pdo = new PDO('mysql:dbname=php_project;host=localhost','root','',[

    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION

]);

$query = $pdo->query('SELECT * FROM post ORDER BY created_at DESC LIMIT 12');
$posts = $query->fetchAll(PDO::FETCH_CLASS,Post::class);

?>

<h1>Mon Blog</h1>



<div class="row">
<?php foreach($posts as $post) : ?>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                 <h5 class="card-title"> <?= $post->getName() ?> </h5>
                 <p class="text-muted"> <?= $post->getCreatedAt()->format('d/m/Y') ?> </p>
                 <p> <?= $post->getExcerpt() ?> </p>
                 <p>
                    <a href="#" class="btn btn-primary">Voir plus</a>
                 </p>
            </div>
        </div>
    </div>
<?php endforeach ?>
</div>





