<?php

use App\database\DataProvider;
use App\Model\Category;

use App\PaginatedQuery;
use App\Pagination;
use App\Table\CategoryTable;
use App\Table\PostTable;
use App\URL;

$title = "Category";

$id =  (int)$params['id'];

$slug = $params['slug'];

$data =  new DataProvider();

$pdo  = $data->connection();

$categoryTable = new CategoryTable($pdo);


$table = new PostTable($pdo);

$category = $categoryTable->find($id);

if($category === false) {

    throw new Exception('Aucun category ne correspond à cet ID');

}

if($category->getSlug() !== $slug) {

    $url = $router->url('category', ['slug' => $category->getSlug(),'id' => $id]);
    http_response_code(301);
    header('Location: ' . $url);

} 



//pagination

/**@var Post[] */




$posts =  $table->findPaginatedForCategory($category->getId());


$link = "";


$link = $router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]);


$data->disconnect($pdo);


?>

<h1> <?= $title ?> </h1>


<h1>Ma category</h1>



<div class="row">
<?php foreach($posts as $post) : ?>
    <div class="col-md-3 mb-3">
       <?php require dirname(__DIR__) . '/post/card.php' ?>
    </div>
<?php endforeach ?>
</div>

<div class="d-flex justify-content-between my-4">

      <?php if($table->getPaginatedQuery()->getCurrentPage()  > 1): ?>
         
        <?php 

        $L = $router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]);

        if($table->getPaginatedQuery()->getCurrentPage() > 2) $L  .= '?page=' . $table->getPaginatedQuery()->getCurrentPage()  -1;

        ?>
           <a href="<?= $L  ?>" class="btn btn-primary">&laquo; Page précédent</a>
       <?php endif ?>


       <?php if ($table->getPaginatedQuery()->getCurrentPage()  < $table->getPaginatedQuery()->getPages()): ?>

            <a href="<?= $router->url('category',['id' => $category->getID(),'slug' => $category->getSlug()]) ?>?page=<?= $table->getPaginatedQuery()->getCurrentPage()  + 1 ?>" class="btn btn-primary">Page suivant &raquo;</a>
        
       <?php endif ?>

</div>
