<?php

use App\database\DataProvider;
use App\Helpers\Text;
use App\Model\Post;
use App\PaginatedQuery;
use App\Pagination;
use App\Router;
use App\URL;

$title = "Mon Blog";

//PDO Initialisation.

$data = new DataProvider();

$pdo = $data->connection();



//ceil eviter la virgule et aussi diviser par 12 c'est le nombre d'article par page.

//pagination

$paginatedQuery = new PaginatedQuery("SELECT * FROM post ORDER BY created_at DESC",
"SELECT COUNT(id) FROM post",
Post::class,
$pdo,
);

/**@var Post[] */
$posts =  $paginatedQuery->getItems();

$data->disconnect($pdo);

?>

<h1>Mon Blog</h1>



<div class="row">
<?php foreach($posts as $post) : ?>
    <div class="col-md-3 mb-3">
       <?php require 'card.php' ?>
    </div>
<?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">


      <?php if($paginatedQuery->getcurrentPage() > 1): ?>
        <?php 
        $link = $router->url('home');
        if($paginatedQuery->getCurrentPage()> 2) $link .= '?page=' . $paginatedQuery->getCurrentPage() -1;
        ?>
           <a href="<?=$link ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($paginatedQuery->getCurrentPage() < $paginatedQuery->getPages()): ?>

            <a href="<?= $router->url('home') ?>?page=<?= $paginatedQuery->getCurrentPage() + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>


</div>





