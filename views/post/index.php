<?php

use App\database\DataProvider;
use App\Helpers\Text;
use App\Model\Post;
use App\PaginatedQuery;
use App\Pagination;
use App\Router;
use App\Table\PostTable;
use App\URL;

$title = "Mon Blog";

//PDO Initialisation.

$data = new DataProvider();

$pdo = $data->connection();

//ceil eviter la virgule et aussi diviser par 12 c'est le nombre d'article par page.

$table = new PostTable($pdo);

//pagination


$posts =  $table->findPaginated();


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


      <?php if($table->getPaginatedQuery()->getcurrentPage() > 1): ?>
        <?php 
        $link = $router->url('home');
        if($table->getPaginatedQuery()->getCurrentPage()> 2) $link .= '?page=' . $table->getPaginatedQuery()->getCurrentPage() -1;
        ?>
           <a href="<?=$link ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($table->getPaginatedQuery()->getCurrentPage() < $table->getPaginatedQuery()->getPages()): ?>

            <a href="<?= $router->url('home') ?>?page=<?= $table->getPaginatedQuery()->getCurrentPage() + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>


</div>





