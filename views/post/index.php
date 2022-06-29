<?php

use App\database\DataProvider;
use App\Helpers\Text;
use App\Model\Post;
use App\Pagination;
use App\Router;
use App\URL;

$title = "Mon Blog";

$perPage = 12;

//PDO Initialisation.

$data = new DataProvider();

$pdo = $data->connection();

$currentPage = URL::getPositiveInt('page',1);



//ceil eviter la virgule et aussi diviser par 12 c'est le nombre d'article par page.

$count = (int)$pdo->query('SELECT COUNT(id) FROM post')->fetch(PDO::FETCH_NUM)[0];

$pages = Pagination::PagesNum($count,$perPage);

Pagination::verification($currentPage,$pages);

if($currentPage === '1') {
    header('Location: ' . $router->url('home'));
    http_response_code(301);
    exit();
}

$offset = Pagination::getOffset($currentPage,$perPage);

$query =  $pdo->query("SELECT * FROM post ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
$posts =  $query->fetchAll(PDO::FETCH_CLASS,Post::class);
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

      <?php if($currentPage > 1): ?>
         
        <?php 
        $link = $router->url('home');
        if($currentPage > 2) $link .= '?page=' . $currentPage -1;
        ?>
           <a href="<?=$link ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($currentPage < $pages): ?>

            <a href="<?= $router->url('home') ?>?page=<?= $currentPage + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
        <?php endif ?>

</div>





